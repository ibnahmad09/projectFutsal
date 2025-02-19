<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Midtrans\Config;
use Midtrans\Transaction;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Field;
use App\Models\User;

class AdminController extends Controller
{

    public function dashboard()
{
    // Ambil data statistik yang diperlukan
    $totalBookings = Booking::count();
    $totalFields = Field::count();
    $recentBookings = Booking::with(['user', 'field'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        // Hitung revenue hari ini
    $todayRevenue = Payment::whereDate('payment_date', today())
    ->where('status', 'paid')
    ->sum('amount');
    // Hitung active users (yang melakukan booking dalam 30 hari terakhir)
    $activeUsers = User::whereHas('bookings', function($query) {
        $query->where('created_at', '>=', now()->subDays(30));
    })->count();

// Hitung field occupancy rate
    $totalSlots = Field::count() * 24; // Asumsi 24 slot per hari
    $bookedSlots = Booking::whereDate('booking_date', today())->count();
    $fieldOccupancy = $totalSlots > 0 ? round(($bookedSlots / $totalSlots) * 100) : 0;

    // Data untuk booking trends
    $bookingTrends = [
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        'data' => Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count')
            ->toArray()
    ];

    // Data untuk field performance
    $fieldPerformanceData = [
        'labels' => Field::pluck('name')->toArray(),
        'data' => Field::withCount('bookings')->pluck('bookings_count')->toArray()
    ];



    return view('admin.dashboard', compact('totalBookings', 'totalFields', 'recentBookings', 'todayRevenue', 'activeUsers',
    'fieldOccupancy', 'bookingTrends',
        'fieldPerformanceData'));
}

    public function bookings()
    {
        $bookings = Booking::with(['user', 'field', 'payment'])
            ->orderBy('booking_date', 'desc')
            ->paginate(10);

        return view('admin.booking', compact('bookings'));
    }
    public function acceptBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);

        // Update payment status
        if($booking->payment_method === 'e-wallet') {
            Payment::where('booking_id', $booking->id)
                ->update(['status' => 'success']);
        }

        return redirect()->back()
            ->with('success', 'Booking berhasil dikonfirmasi');
    }

    public function rejectBooking($id)
    {
        $booking = Booking::findOrFail($id);
    
        // Update status booking
        $booking->update(['status' => 'canceled']);
    
        // Jika pembayaran menggunakan e-wallet, lakukan refund
        if ($booking->payment_method === 'e-wallet') {
            try {
                Config::$serverKey = config('services.midtrans.server_key');
                Config::$isProduction = config('services.midtrans.is_production');
    
                $payment = Payment::where('booking_id', $booking->id)->first();
    
                if ($payment) {
                    $refund = Transaction::refund($payment->transaction_id, [
                        'refund_key' => 'refund-' . time(),
                        'amount' => $booking->total_price,
                        'reason' => 'Booking ditolak oleh admin'
                    ]);
    
                    $payment->update([
                        'status' => 'refunded',
                        'midtrans_response' => json_encode($refund)
                    ]);
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Gagal melakukan refund: ' . $e->getMessage());
            }
        }
    
        return redirect()->back()
            ->with('success', 'Booking berhasil ditolak dan status diubah menjadi canceled');
    }
}
