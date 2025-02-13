<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Providers\MidtransServiceProvider;
use Midtrans\Config;
use Midtrans\Snap;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $fields = Field::all();
        $fields = Field::where('is_available', true)->get();

        $currentBookings = Booking::with(['field', 'user'])
        ->whereDate('booking_date', now()->toDateString())
        ->where(function($query) {
            $query->whereTime('end_time', '>=', now()->toTimeString())
                ->orWhere('status', 'active');
        })
        ->orderBy('start_time')
        ->get();
        return view('user.index', compact('fields','currentBookings'));
        
    }
    public function getCurrentBookings()
{
    $currentBookings = Booking::with(['field', 'user'])
        ->whereDate('booking_date', now()->toDateString())
        ->where(function($query) {
            $query->whereTime('end_time', '>=', now()->toTimeString())
                ->orWhere('status', 'active');
        })
        ->orderBy('start_time')
        ->get();

    return response()->json($currentBookings);
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'field_id' => 'required|exists:fields,id',
        'booking_date' => 'required|date|after:today',
        'start_time' => 'required|date_format:H:i',
        'duration' => 'required|integer|min:1|max:4',
        'payment_method' => 'required|in:cash,transfer,e-wallet'
    ]);

    $field = Field::findOrFail($request->field_id);

    // Hitung end_time
    $start = \Carbon\Carbon::parse($request->start_time);
    $end = $start->copy()->addHours($request->duration);

    // Cek ketersediaan
    if (!Booking::isTimeValid($field->id, $request->booking_date, $start->format('H:i'), $end->format('H:i'))) {
        return response()->json([
            'success' => false,
            'message' => 'Waktu booking tidak tersedia'
        ], 422);
    }

    // Create booking
    $booking = Booking::create([
        'booking_code' => 'BOOK-' . strtoupper(uniqid()),
        'user_id' => Auth::id(),
        'field_id' => $field->id,
        'booking_date' => $request->booking_date,
        'start_time' => $start->format('H:i'),
        'end_time' => $end->format('H:i'),
        'duration' => $request->duration,
        'total_price' => $field->price_per_hour * $request->duration,
        'payment_method' => $request->payment_method,
        'status' => 'pending',
        'expires_at' => now()->addMinutes(15)
    ]);

    // Jika metode pembayaran e-wallet
    if($request->payment_method === 'e-wallet') {
        try {
            // Setup Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Parameter transaksi
            $params = [
                'transaction_details' => [
                    'order_id' => $booking->id . '-' . uniqid(),
                    'gross_amount' => $booking->total_price,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone_number,
                ],
                'enabled_payments' => ['gopay', 'shopeepay'],
                'expiry' => [
                    'duration' => 2,
                    'unit' => 'hour'
                ],
                'recurring' => true // Tambahkan ini untuk recurring payment
            ];

            // Dapatkan Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Update booking dengan snap token
            $booking->update(['snap_token' => $snapToken]);

            // Simpan ke tabel payments
            Payment::create([
                'booking_id' => $booking->id,
                'payment_method' => 'e-wallet',
                'amount' => $booking->total_price,
                'status' => 'pending',
                'transaction_id' => $params['transaction_details']['order_id'],
                'midtrans_response' => json_encode(['snap_token' => $snapToken])
            ]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'booking_id' => $booking->id,
                'message' => 'Lanjutkan ke pembayaran'
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Payment Error:', [
                'error' => $e->getMessage(),
                'booking_id' => $booking->id,
                'user_id' => Auth::id()
            ]);
            $booking->delete();
            return response()->json([
                'success' => false,
                'message' => 'Error pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    // Untuk metode pembayaran non e-wallet
    return response()->json([
        'success' => true,
        'message' => 'Booking berhasil dibuat'
    ]);
}
public function handleNotification(Request $request)
{
    $payload = $request->getContent();
    $data = json_decode($payload, true);

    Log::info('Midtrans Transaction Status:', [
        'order_id' => $data['order_id'],
        'status' => $data['transaction_status'],
        'payment_type' => $data['payment_type'],
        'fraud_status' => $data['fraud_status'],
        'payload' => $data
    ]);

    $serverKey = env('MIDTRANS_SERVER_KEY');
    $signature = hash('sha512', $payload . $serverKey);

    if ($signature !== $request->header('X-Signature')) {
        Log::error('Invalid Midtrans Signature:', [
            'received_signature' => $request->header('X-Signature'),
            'computed_signature' => $signature
        ]);
        return response()->json(['status' => 'Invalid signature'], 403);
    }

    $data = json_decode($payload, true);
    $orderId = explode('-', $data['order_id'])[0];

    $booking = Booking::find($orderId);
    $payment = Payment::where('transaction_id', $data['order_id'])->first();

    if (!$booking || !$payment) {
        return response()->json(['status' => 'Order not found'], 404);
    }

    switch ($data['transaction_status']) {
        case 'capture':
        case 'settlement':
            $booking->update(['status' => 'confirmed']);
            $payment->update([
                'status' => 'success',
                'payment_date' => now(),
                'midtrans_response' => $payload
            ]);
            break;

            case 'expire':
                $booking->update(['status' => 'canceled']);
                $payment->update(['status' => 'expired']);
                // Kirim notifikasi ke user
                $user = $booking->user;
                $user->notify(new PaymentExpiredNotification($booking));
                break;

        case 'cancel':
            $booking->update(['status' => 'canceled']);
            $payment->update(['status' => 'canceled']);
            break;

        case 'chargeback':
            $booking->update(['status' => 'canceled']);
            $payment->update(['status' => 'chargeback']);
            break;

        case 'success':
            $booking->update(['status' => 'confirmed']);
            $payment->update([
                'status' => 'success',
                'payment_date' => now(),
                'midtrans_response' => $payload
            ]);
            break;
    }


    return response()->json(['status' => 'success']);
}

public function callback(Request $request)
{
    $payment = Payment::whereHas('booking', function($query) {
        $query->where('user_id', Auth::id());
    })->latest()->first();
    return view('user.callback', compact('payment'));
}

public function showBooking(Booking $booking)
{
    // Pastikan booking milik user yang sedang login
    if ($booking->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    // Load relasi yang diperlukan
    $booking->load(['field', 'payment']);

    return view('user.booking-detail', compact('booking'));
}

public function indexBookings()
{
    $bookings = Auth::user()->bookings()
        ->with(['field', 'payment'])
        ->orderBy('booking_date', 'desc')
        ->paginate(10);

    return view('user.riwayat', compact('bookings'));
}

public function refundBooking(Booking $booking)
{
    try {
        // Setup Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Parameter refund
        $params = [
            'refund_key' => 'refund-' . time(),
            'amount' => $booking->total_price,
            'reason' => 'Booking cancellation'
        ];

        // Proses refund melalui Midtrans
        $refund = \Midtrans\Transaction::refund($booking->payment->transaction_id, $params);

        // Update status pembayaran
        $booking->payment->update(['status' => 'refunded']);

        return response()->json(['success' => true, 'message' => 'Refund processed successfully']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}
