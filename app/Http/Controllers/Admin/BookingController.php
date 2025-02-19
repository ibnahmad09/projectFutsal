<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class BookingController extends Controller
{
    // Menampilkan semua booking
    public function index()
    {
        $bookings = Booking::with(['user', 'field', 'payment'])
            ->latest()
            ->paginate(10);
            $bookingTrends = [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                    ->groupBy('month')
                    ->pluck('count')
                    ->toArray()
            ];

            // Data untuk status distribution
            $statusDistribution = [
                'labels' => ['Confirmed', 'Pending', 'Completed', 'Canceled'],
                'data' => [
                    Booking::where('status', 'confirmed')->count(),
                    Booking::where('status', 'pending')->count(),
                    Booking::where('status', 'completed')->count(),
                    Booking::where('status', 'canceled')->count()
                ]
            ];

        return view('admin.booking', compact('bookings', 'bookingTrends', 'statusDistribution'));
    }

    // Menampilkan form tambah booking
    public function create()
    {
        $users = User::where('role', 'user')->get();
        $fields = Field::where('is_available', 'available')->get();

        return view('admin.create-booking', compact('users', 'fields'));
    }

    // Menyimpan booking baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'payment_method' => 'required|in:cash,transfer,e_wallet',
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Hitung durasi dan harga
        $field = Field::findOrFail($request->field_id);
        $duration = $request->duration;
        $total_price = $duration * $field->price_per_hour;

        // Hitung end_time
        $start_time = Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = $start_time->copy()->addHours($duration);

        // Cek ketersediaan
        if ($this->checkBookingConflict($request->field_id, $request->booking_date, $request->start_time, $request->end_time)) {
            return redirect()->back()
                ->withErrors(['time' => 'Waktu booking bertabrakan dengan booking lain'])
                ->withInput();
        }

        // Buat booking
        $booking = Auth::user()->bookings()->create([
            'booking_code' => 'BOOK-' . strtoupper(uniqid()),
            'field_id' => $field->id,
            'booking_date' => $request->booking_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'duration' => $duration,
            'total_price' => $total_price,
            'status' => 'pending'
        ]);

        // Buat pembayaran
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $total_price,
            'method' => $request->payment_method,
            'status' => $request->payment_status,
            'payment_date' => $request->payment_status === 'paid' ? now() : null
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dibuat');
    }

    // Menampilkan detail booking
    public function show(Booking $booking)
    {
        $booking->load(['user', 'field', 'payment']);
        return view('admin.show-booking', compact('booking'));
    }

    // Menampilkan form edit
    public function edit(Booking $booking)
    {
        // Get available fields and users
        $fields = Field::where('is_available', 1)->get();
        $users = User::where('role', 'user')->get();
        $payment = Payment::where('status', 'pending')->get();

        return view('admin.edit-booking', compact('booking', 'fields', 'users', 'payment'));
    }

    // Update booking
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:pending,confirmed,completed,canceled'
        ]);

        // Calculate duration and total price
        $start = \Carbon\Carbon::parse($request->start_time);
        $end = \Carbon\Carbon::parse($request->end_time);
        $duration = $end->diffInHours($start);
        $field = Field::findOrFail($request->field_id);
        $totalPrice = $duration * $field->price_per_hour;

        // Update booking
        $booking->update([
            'field_id' => $request->field_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $duration,
            'total_price' => $totalPrice,
            'status' => $request->status
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil diperbarui');
    }

    public function accept(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        return back()->with('success', 'Booking berhasil dikonfirmasi');
    }

    public function reject(Booking $booking)
    {
        $booking->update(['status' => 'canceled']);
        return back()->with('success', 'Booking berhasil dibatalkan');
    }

    // Hapus booking
    public function destroy(Booking $booking)
    {
        try {
            // Hapus pembayaran terkait jika ada
            if ($booking->payment) {
                $booking->payment->delete();
            }

            // Hapus booking
            $booking->delete();

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Gagal menghapus booking: ' . $e->getMessage());
        }
    }

    // Fungsi untuk cek konflik booking
    private function checkBookingConflict($fieldId, $date, $start, $end, $exceptId = null)
    {
        $query = Booking::where('field_id', $fieldId)
            ->where('booking_date', $date)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                  ->orWhereBetween('end_time', [$start, $end])
                  ->orWhereRaw('? BETWEEN start_time AND end_time', [$start])
                  ->orWhereRaw('? BETWEEN start_time AND end_time', [$end]);
            });

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->exists();
    }
}
