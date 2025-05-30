<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Booking;

class MemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $member = $user->member;

        // Ambil jadwal yang harus dibooking oleh member
        $requiredBookings = Booking::where('user_id', $user->id)
            ->where('booking_date', '>=', now()->startOfWeek())
            ->where('booking_date', '<=', now()->endOfWeek())
            ->get();

        // Hitung jumlah kali user sudah bermain
        $totalPlayed = Booking::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->count();

        return view('user.member', compact('member', 'requiredBookings', 'totalPlayed'));
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
        $user = Auth::user();
        $member = $user->member;

        // Cek apakah user sudah menyelesaikan 4 minggu dan belum menggunakan fitur member
        if ($member && $member->weeks_completed >= 4 && !$member->is_member_used) {
            // Buat booking gratis
            $booking = Booking::create([
                'user_id' => $user->id,
                'field_id' => $request->field_id,
                'booking_date' => $request->booking_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'duration' => $request->duration,
                'total_price' => 0,
                'status' => 'pending',
                'is_member_booking' => true,
            ]);

            // Tandai fitur member sudah digunakan
            $member->update(['is_member_used' => true]);

            return redirect()->route('user.member')->with('success', 'Booking gratis berhasil dibuat!');
        }

        return redirect()->route('user.member')->with('error', 'Anda belum memenuhi syarat untuk menggunakan fitur member.');
    }
}
