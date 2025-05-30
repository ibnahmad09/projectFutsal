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
            $end_time = Carbon::parse($request->start_time)->addHours($request->duration)->format('H:i');

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
