<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LapanganController extends Controller
{
    public function create(Field $field)
    {
        return view('user.lapangan', compact('field'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => [
                'required',
                'date',
                Rule::unique('bookings')->where(function ($query) use ($request) {
                    return $query->where('field_id', $request->field_id)
                        ->whereDate('booking_date', $request->booking_date);
                })->ignore($request->id)
            ],
            'time_slots' => 'required|array|min:1',
            'time_slots.*' => 'date_format:H:i'
        ]);

        $field = Field::findOrFail($request->field_id);
        $slots = $this->processTimeSlots($request->time_slots);

        foreach ($slots as $slot) {
            if (!Booking::isTimeValid($field->id, $request->booking_date, $slot['start'], $slot['end'])) {
                return back()->withErrors(['time' => 'Slot waktu sudah terisi!']);
            }
        }

        $booking = Auth::user()->bookings()->create([
            'field_id' => $field->id,
            'booking_date' => $request->booking_date,
            'start_time' => $slots[0]['start'],
            'end_time' => end($slots)['end'],
            'duration' => count($slots),
            'total_price' => count($slots) * $field->price_per_hour,
            'status' => 'pending'
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking berhasil dibuat!');
    }

    private function processTimeSlots($slots)
    {
        sort($slots);
        $processed = [];
        $currentStart = null;
        $currentEnd = null;

        foreach ($slots as $slot) {
            $time = \Carbon\Carbon::parse($slot);

            if (!$currentStart) {
                $currentStart = $time;
                $currentEnd = $time->addHour();
            } else {
                if ($time->eq($currentEnd)) {
                    $currentEnd = $time->addHour();
                } else {
                    $processed[] = [
                        'start' => $currentStart->format('H:i'),
                        'end' => $currentEnd->format('H:i')
                    ];
                    $currentStart = $time;
                    $currentEnd = $time->addHour();
                }
            }
        }

        if ($currentStart) {
            $processed[] = [
                'start' => $currentStart->format('H:i'),
                'end' => $currentEnd->format('H:i')
            ];
        }

        return $processed;
    }
}
