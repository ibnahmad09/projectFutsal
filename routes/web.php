<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\FieldController;
use \App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\User\MemberController as UserMemberController;

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





// Route yang bisa diakses tanpa login
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('user.home.index')->middleware('auth');
Route::get('/about', [AboutController::class, 'index'])->name('user.abouts.index');
Route::get('/lapangan', [LapanganController::class, 'index'])->name('user.lapangan.index');
Route::get('/lapangan/{field}', [LapanganController::class, 'show'])->name('user.lapangan.show');
Route::get('/lapangan/{id}', [FieldController::class, 'showFieldDetail'])->name('field.detail');

Auth::routes(['verify' => true]);

// Route yang memerlukan login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('user.home.index');
    Route::post('/bookings',[HomeController::class, 'store'])->name('user.bookings.store');
    Route::post('/midtrans-notification', [HomeController::class, 'handleNotification']);
    Route::get('/bookings/callback', [HomeController::class, 'callback'])->name('user.callback');
    Route::get('/bookings/{booking} ', [HomeController::class, 'showBooking'])->name('user.bookings.show');
    Route::get('/booking', [HomeController::class, 'indexBookings'])->name('user.bookings.index');
    Route::get('/profil', [ProfileController::class, 'show'])->name('user.profil.show');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('user.profil.edit');
    Route::put('/profil/update', [ProfileController::class, 'update'])->name('update.profile');
    Route::get('/pengaturan', [ProfileController::class, 'pengaturan'])->name('user.pengaturan');
    Route::put('/profil/ubah-password', [ProfileController::class, 'updatePassword'])->name('user.profil.update-password');
    Route::get('/member/use', [UserMemberController::class, 'useMember'])->name('user.member.use');
    Route::post('/member/store', [UserMemberController::class, 'storeMemberBooking'])->name('user.member.store');
    Route::get('/member', [App\Http\Controllers\User\MemberController::class, 'index'])->name('user.member');
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

        Route::get('/users', [UserController::class, 'users'])->name('admin.users.index');
        Route::get('/users/create', [UserController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [UserController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [UserController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroyUser'])->name('admin.users.destroy');

        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics');

        Route::resource('members', MemberController::class);
        Route::post('members/{member}/update-weeks', [\App\Http\Controllers\Admin\MemberController::class, 'updateWeeksCompleted'])->name('admin.members.update-weeks');

        Route::delete('/field-images/{image}', [FieldController::class, 'destroyImage'])->name('admin.field-images.destroy');
    });






