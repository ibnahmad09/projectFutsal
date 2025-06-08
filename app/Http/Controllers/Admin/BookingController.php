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
        $totalBookings = Booking::count();
        $bookings = Booking::with(['field', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $bookingTrends = $this->getBookingTrends();
        $statusDistribution = $this->getStatusDistribution();
        $fields = Field::where('is_available', true)->get();

        return view('admin.booking', compact('bookings', 'bookingTrends', 'statusDistribution', 'fields', 'totalBookings'));
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
        try {
            $validator = Validator::make($request->all(), [
                'field_id' => 'required|exists:fields,id',
                'booking_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required|date_format:H:i',
                'duration' => 'required|integer|min:1|max:4',
                'payment_method' => 'required|in:cash,e-wallet',
                'customer_name' => 'required',
                'customer_phone' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Hitung durasi dan harga
            $field = Field::findOrFail($request->field_id);
            $duration = $request->duration;
            $total_price = $duration * $field->price_per_hour;

            // Hitung end_time
            $start_time = Carbon::createFromFormat('H:i', $request->start_time);
            $end_time = $start_time->copy()->addHours($duration);

            // Cek ketersediaan
            if ($this->checkBookingConflict($request->field_id, $request->booking_date, $request->start_time, $end_time->format('H:i'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu booking bertabrakan dengan booking lain'
                ], 422);
            }

            // Buat booking
            $booking = Booking::create([
                'booking_code' => 'BOOK-' . strtoupper(uniqid()),
                'user_id' => null,
                'field_id' => $field->id,
                'booking_date' => $request->booking_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'duration' => $duration,
                'total_price' => $total_price,
                'status' => 'confirmed',
                'payment_method' => $request->payment_method,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'is_manual_booking' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dibuat',
                'booking' => $booking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Menampilkan detail booking
    public function show(Booking $booking)
    {
        $booking->load(['field', 'user']);
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

    private function getBookingTrends()
    {
        // Implementasi untuk mendapatkan tren booking
        return [
            'labels' => [],
            'data' => []
        ];
    }

    private function getStatusDistribution()
    {
        // Implementasi untuk mendapatkan distribusi status
        return [
            'labels' => [],
            'data' => []
        ];
    }
}
