<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Booking;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $member = $user->member;

        $requiredBookings = collect();

        if ($member && $member->is_active && $member->start_date) {
            $startDate = \Carbon\Carbon::parse($member->start_date)->setTimezone('Asia/Jakarta');

            // Tampilkan tanggal mulai + 3 minggu berikutnya (total 4 minggu)
            for ($i = 0; $i < 4; $i++) {
                $bookingDate = $startDate->copy()->addWeeks($i);
                // Cek apakah user sudah booking di tanggal ini
                $booking = \App\Models\Booking::where('user_id', $user->id)
                    ->whereDate('booking_date', $bookingDate->toDateString())
                    ->first();

                $requiredBookings->push((object)[
                    'booking_date' => $bookingDate->toDateString(),
                    'start_time' => $booking->start_time ?? '-',
                    'end_time' => $booking->end_time ?? '-',
                    'status' => $booking->status ?? 'pending',
                ]);
            }
        }

        // Data lain seperti $totalPlayed bisa tetap dikirim
        return view('user.member', [
            'requiredBookings' => $requiredBookings,
            'totalPlayed' => $user->bookings()->count(),
        ]);
    }

    public function useMember()
    {
        $user = Auth::user();
        $member = $user->member;

        // Ambil semua lapangan yang tersedia
        $fields = \App\Models\Field::all();

        // Cek apakah user sudah menyelesaikan 4 minggu dan belum menggunakan fitur member
        if ($member && $member->weeks_completed >= 4 && !$member->is_member_used) {
            return view('user.use_member', compact('member', 'fields'));
        }

        return redirect()->route('user.member')->with('error', 'Anda belum memenuhi syarat untuk menggunakan fitur member.');
    }

    public function storeMemberBooking(Request $request)
    {
        try {
            $user = Auth::user();
            $member = $user->member;

            // Cek apakah user sudah menyelesaikan 4 minggu dan belum menggunakan fitur member
            if (!$member || $member->weeks_completed < 4 || $member->is_member_used) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum memenuhi syarat untuk menggunakan fitur member.'
                ], 400);
            }

            // Validasi input
            $request->validate([
                'field_id' => 'required|exists:fields,id',
                'booking_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required|date_format:H:i',
                'duration' => 'required|integer|min:1|max:4'
            ]);

            // Hitung waktu selesai
            $end_time = Carbon::parse($request->start_time)->addHours($request->duration)->format('H:i')->setTimezone('Asia/Jakarta');

            // Buat booking gratis
            $booking = Booking::create([
                'booking_code' => 'BOOK-' . strtoupper(uniqid()), // Generate booking code
                'user_id' => $user->id,
                'field_id' => $request->field_id,
                'booking_date' => $request->booking_date,
                'start_time' => $request->start_time,
                'end_time' => $end_time,
                'duration' => $request->duration,
                'total_price' => 0,
                'status' => 'pending',
                'is_member_booking' => true,
            ]);

            // Tandai fitur member sudah digunakan
            $member->update(['is_member_used' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Booking gratis berhasil dibuat!'
            ]);
        } catch (\Exception $e) {
            // Tangkap semua exception dan kembalikan pesan error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}
