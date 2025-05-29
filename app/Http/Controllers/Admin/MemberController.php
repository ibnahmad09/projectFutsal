<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Booking;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('user')->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.members.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
        ]);

        Member::create([
            'user_id' => $request->user_id,
            'start_date' => $request->start_date,
            'is_active' => true,
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan');
    }
    public function updateWeeksCompleted(Member $member)
    {
        $member->update([
            'weeks_completed' => $member->weeks_completed + 1,
        ]);

        return back()->with('success', 'Minggu berhasil ditambahkan');
    }

    public function checkMissedSchedule()
    {
        $members = Member::where('is_active', true)->get();

        foreach ($members as $member) {
            $lastBooking = Booking::where('user_id', $member->user_id)
                ->orderBy('booking_date', 'desc')
                ->first();

            if ($lastBooking && $lastBooking->booking_date < now()->subWeek()) {
                $member->update(['is_active' => false]);
                // Kirim notifikasi ke user
            }
        }
    }
}
