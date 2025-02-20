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

    // Get booked slots only for this specific field
    $bookedSlots = Booking::where('field_id', $field->id)
        ->whereDate('booking_date', $date)
        ->where('status', '!=', 'canceled')
        ->get()
        ->flatMap(function ($booking) {
            return Carbon\CarbonPeriod::create(
                $booking->start_time,
                '1 hour',
                $booking->end_time
            )->toArray();
        })
        ->map(fn($time) => $time->format('H:i'));

    // Generate all possible slots based on this field's opening hours
    $allSlots = [];
    $current = Carbon\Carbon::parse($field->open_time);
    $closeTime = Carbon\Carbon::parse($field->close_time);

    // If booking is for today, start from current time
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
    $availableSlots = array_diff($allSlots, $bookedSlots->toArray());

    return response()->json([
        'field_id' => $field->id,
        'available_slots' => array_values($availableSlots)
    ]);
});

Route::get('/real-time-schedule', function() {
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
                'field_name' => $booking->field->name,
                'user_name' => $booking->user->name,
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
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
                'field_name' => $booking->field->name,
                'user_name' => $booking->user->name,
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
                'status' => $booking->status,
                'type' => 'upcoming'
            ];
        });

    return response()->json([...$bookings, ...$upcomingBookings]);
});
