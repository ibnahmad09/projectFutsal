<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'address' => ['required', 'string'],
        ]);

        $user = Auth::user();
        $user->address = $request->address;
        $user->save();

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function show()
    {
        $user = Auth::user();
        return view('user.profil', compact('user'));
    }
}
