<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Booking;
use App\Models\Field;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/current-bookings', [HomeController::class, 'getCurrentBookings']);

Route::get('/current-bookings', function() {
    $bookings = Booking::with(['field', 'user'])
        ->whereDate('booking_date', now()->toDateString())
        ->whereTime('end_time', '>=', now()->toTimeString())
        ->orderBy('start_time')
        ->get()
        ->map(function($booking) {
            return [
                'field' => $booking->field,
                'user' => $booking->user,
                'start_time' => date('H:i', strtotime($booking->start_time)),
                'end_time' => date('H:i', strtotime($booking->end_time)),
                'status' => $booking->status
            ];
        });

    return response()->json($bookings);
});

Route::get('/available-times/{field}', function (Field $field) {
    $date = request('date');
    $now = now();
    $isToday = $date === $now->format('Y-m-d');

    // Get booked slots
    $bookedSlots = Booking::where('field_id', $field->id)
        ->whereDate('booking_date', $date)
        ->where('status', '!=', 'canceled')
        ->get()
        ->flatMap(function ($booking) {
            $slots = [];
            $start = Carbon\Carbon::parse($booking->start_time);
            $end = Carbon\Carbon::parse($booking->end_time);

            while ($start->lt($end)) {
                $slots[] = $start->format('H:i');
                $start->addHour();
            }
            return $slots;
        })
        ->toArray();

    // Generate all possible slots
    $allSlots = [];
    $current = Carbon\Carbon::parse($field->open_time);
    $closeTime = Carbon\Carbon::parse($field->close_time);

    if ($isToday) {
        $current = $now->copy()->addHour()->startOfHour();
        if ($current->lt(Carbon\Carbon::parse($field->open_time))) {
            $current = Carbon\Carbon::parse($field->open_time);
        }
    }

    while ($current->lt($closeTime)) {
        $allSlots[] = $current->format('H:i');
        $current->addHour();
    }

    // Filter out booked slots
    $availableSlots = array_values(array_diff($allSlots, $bookedSlots));

    // Debug logging
    \Log::info('Available Times Debug', [
        'field_id' => $field->id,
        'date' => $date,
        'booked_slots' => $bookedSlots,
        'all_slots' => $allSlots,
        'available_slots' => $availableSlots
    ]);

    return response()->json([
        'field_id' => $field->id,
        'available_slots' => $availableSlots,
        'debug' => [
            'booked_slots' => $bookedSlots,
            'all_slots' => $allSlots
        ]
    ]);
});

Route::get('/real-time-schedule', function() {
    try {
        $bookings = \App\Models\Booking::with(['field', 'user'])
            ->whereDate('booking_date', now()->toDateString())
            ->where(function($query) {
                $query->whereTime('end_time', '>=', now()->toTimeString())
                    ->orWhere('status', 'active');
            })
            ->orderBy('start_time')
            ->get()
            ->map(function($booking) {
                return [
                    'field_name' => $booking->field ? $booking->field->name : 'Unknown Field',
                    'user_name' => $booking->user ? $booking->user->name : 'Unknown User',
                    'start_time' => $booking->start_time->format('H:i'), // Format waktu menjadi H:i
                    'end_time' => $booking->end_time->format('H:i'),     // Format waktu menjadi H:i
                    'status' => $booking->status,
                    'type' => 'ongoing'
                ];
            });

        $upcomingBookings = \App\Models\Booking::with(['field', 'user'])
            ->whereDate('booking_date', '>', now()->toDateString())
            ->where('status', 'confirmed')
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get()
            ->map(function($booking) {
                return [
                    'field_name' => $booking->field ? $booking->field->name : 'Unknown Field',
                    'user_name' => $booking->user ? $booking->user->name : 'Unknown User',
                    'start_time' => $booking->start_time->format('H:i'), // Format waktu menjadi H:i
                    'end_time' => $booking->end_time->format('H:i'),     // Format waktu menjadi H:i
                    'status' => $booking->status,
                    'type' => 'upcoming'
                ];
            });

        return response()->json([...$bookings, ...$upcomingBookings]);
    } catch (\Exception $e) {
        \Log::error('Error in real-time-schedule: ' . $e->getMessage());
        return response()->json(['error' => 'Terjadi kesalahan saat mengambil data jadwal'], 500);
    }
});
