<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\FieldController;
use \App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReportController;


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


Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('user.home.index');
    Route::post('/bookings',[HomeController::class, 'store'])->name('user.bookings.store');
    Route::get('/about', [AboutController::class, 'index'])->name('user.abouts.index');
    Route::post('/midtrans-notification', [HomeController::class, 'handleNotification']);
    Route::get('/bookings/callback', [HomeController::class, 'callback'])->name('user.callback');
    Route::get('/bookings/{booking} ', [HomeController::class, 'showBooking'])->name('user.bookings.show');
    Route::get('/booking', [HomeController::class, 'indexBookings'])->name('user.bookings.index');
    Route::get('/profil', [ProfileController::class, 'show'])->name('user.profil.show');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('user.profil.edit');
    Route::put('/profil/update', [ProfileController::class, 'update'])->name('update.profile');
    Route::get('/pengaturan', [ProfileController::class, 'pengaturan'])->name('user.pengaturan');

    });

    Route::get('/lapangan-detail', function () {
        return view('user.lapangan-detail');
    });

    



    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/fields', [FieldController::class, 'index'])->name('admin.fields.index');
        Route::get('/fields/create', [FieldController::class, 'create'])->name('admin.fields.create');
        Route::post('/fields', [FieldController::class, 'store'])->name('admin.fields.store');
        Route::get('/fields/{field}/edit', [FieldController::class, 'edit'])->name('admin.fields.edit');
        Route::put('/fields/{field}', [FieldController::class, 'update'])->name('admin.fields.update');
        Route::delete('/fields/{field}', [FieldController::class, 'destroy'])->name('admin.fields.destroy');

        Route::resource('bookings', BookingController::class)
        ->names([
            'index' => 'admin.bookings.index',
            'create' => 'admin.bookings.create',
            'store' => 'admin.bookings.store',
            'show' => 'admin.bookings.show',
            'edit' => 'admin.bookings.edit',
            'update' => 'admin.bookings.update',
            'destroy' => 'admin.bookings.destroy'
        ]);
  
        Route::post('/bookings/{id}/accept', [AdminController::class, 'acceptBooking'])->name('admin.bookings.accept');
        Route::post('/bookings/{id}/reject', [AdminController::class, 'rejectBooking'])->name('admin.bookings.reject');
       

        Route::prefix('reports')->group(function () {
            Route::get('/create', [ReportController::class, 'create'])->name('admin.reports.create');
            Route::post('/', [ReportController::class, 'store'])->name('admin.reports.store');
            Route::get('/', [ReportController::class, 'index'])->name('admin.reports.index');
            Route::get('/{report}', [ReportController::class, 'show'])->name('admin.reports.show');
            Route::delete('/{report}', [ReportController::class, 'destroy'])->name('admin.reports.destroy');
        });

        
    });

Auth::routes();





