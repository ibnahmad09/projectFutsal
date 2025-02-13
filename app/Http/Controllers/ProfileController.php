<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone_number' => ['required', 'string', 'max:15'],
        'address' => ['required', 'string', 'max:255'],
    ]);

    $user = Auth::user();
    $user->update([
        'name' => $request->name,
        'phone_number' => $request->phone_number,
        'address' => $request->address,
    ]);

    return redirect()->route('user.profil.show')->with('success', 'Profil berhasil diperbarui!');
}

    public function show()
    {
        $user = Auth::user();
        return view('user.profil', compact('user'));
    }
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit-profil', compact('user'));
    }
    public function pengaturan()
    {
        $user = Auth::user();
        return view('user.pengaturan', compact('user'));
    }
}

