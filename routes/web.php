<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('user.index');
});

Route::get('/lapangan', function () {
    return view('user.lapangan');
});

Route::get('/lapangan-detail', function () {
    return view('user.lapangan-detail');
});



Route::get('/profil', function () {
    return view('user.profil');
});


Route::get('/tentang', function () {
    return view('user.tentang');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
