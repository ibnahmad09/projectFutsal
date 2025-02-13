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

    $bookedSlots = Booking::where('field_id', $field->id)
        ->whereDate('booking_date', $date)
        ->get()
        ->flatMap(function ($booking) {
            return Carbon\CarbonPeriod::create(
                $booking->start_time,
                '1 hour',
                $booking->end_time
            )->toArray();
        })
        ->map(fn($time) => $time->format('H:i'));

    $allSlots = [];
    $current = Carbon\Carbon::parse($field->open_time);
    $endTime = Carbon\Carbon::parse($field->close_time);

    while ($current < $endTime) {
        $allSlots[] = $current->format('H:i');
        $current->addHour();
    }

    $availableSlots = array_diff($allSlots, $bookedSlots->toArray());

    return response()->json([
        'available_slots' => array_values($availableSlots)
    ]);
});
