<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Midtrans\Config;
use Midtrans\Transaction;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Field;

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

    return view('admin.dashboard', compact('totalBookings', 'totalFields', 'recentBookings'));
}

    public function bookings()
    {
        $bookings = Booking::with(['user', 'field', 'payment'])
            ->orderBy('booking_date', 'desc')
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
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

    // Jika booking sudah canceled, kembalikan pesan error
    if ($booking->status === 'canceled') {
        return redirect()->back()
            ->with('error', 'Booking sudah dalam status canceled');
    }

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
