<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LapanganController extends Controller
{
    // Menampilkan daftar lapangan
    public function index()
    {
        $fields = Field::where('is_available', true)
            ->with('images')
            ->paginate(9);

        return view('user.lapangan', compact('fields'));
    }

    // Menampilkan detail lapangan
    public function show(Field $field)
    {
        $field->load('images');
        
        // Cek ketersediaan lapangan
        $isAvailable = $field->is_available;
        
        // Ambil jadwal booking hari ini
        $todayBookings = Booking::where('field_id', $field->id)
            ->whereDate('booking_date', today())
            ->get();

        return view('user.lapangan-detail', compact('field', 'isAvailable', 'todayBookings'));
    }

    // Proses booking lapangan
    public function store(Request $request, Field $field)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->booking_date == now()->format('Y-m-d') && 
                        Carbon\Carbon::parse($value)->lt(now()->addHour()->startOfHour())) {
                        $fail('Waktu booking tidak boleh lebih awal dari waktu sekarang');
                    }
                }
            ],
            'duration' => 'required|integer|min:1|max:4',
            'payment_method' => 'required|in:cash,transfer,e-wallet'
        ]);

        // Hitung waktu selesai
        $start = Carbon::parse($request->start_time);
        $end = $start->copy()->addHours($request->duration);

        // Cek ketersediaan waktu
        $isAvailable = Booking::where('field_id', $field->id)
            ->whereDate('booking_date', $request->booking_date)
            ->where(function($query) use ($start, $end) {
                $query->whereBetween('start_time', [$start->format('H:i'), $end->format('H:i')])
                    ->orWhereBetween('end_time', [$start->format('H:i'), $end->format('H:i')]);
            })
            ->doesntExist();

        if (!$isAvailable) {
            return back()->withErrors(['time' => 'Waktu yang dipilih sudah terbooking!']);
        }

        // Hitung total harga
        $totalPrice = $field->price_per_hour * $request->duration;

        // Buat booking
        $booking = Auth::user()->bookings()->create([
            'field_id' => $field->id,
            'booking_date' => $request->booking_date,
            'start_time' => $start->format('H:i'),
            'end_time' => $end->format('H:i'),
            'duration' => $request->duration,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        return redirect()->route('user.lapangan.show', $field)
            ->with('success', 'Booking berhasil dibuat! Kode Booking: ' . $booking->booking_code);
    }
}
