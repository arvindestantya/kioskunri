<?php

use App\Models\Faculty;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlyerController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\FacultyController as SuperAdminFacultyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========================================================================
// ROUTE UNTUK ADMIN AREA DAN AUTENTIKASI (DIPINDAHKAN KE ATAS)
// ========================================================================

// Route dashboard utama sekarang menunjuk ke data tamu
Route::get('/dashboard', [GuestController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/feedbacks', [FeedbackController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('feedbacks');

// Include route autentikasi dari Breeze (login, register, dll.)
// Ini harus diproses SEBELUM route dinamis {faculty:slug}
require __DIR__.'/auth.php';

// Route untuk area profile yang dibuat oleh Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk fitur yang bisa diakses semua admin
Route::middleware(['auth', 'verified'])->group(function() {
    Route::delete('/admin/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
    Route::get('/admin/guests/export', [GuestController::class, 'export'])->name('guests.export');
    Route::delete('/admin/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');
    Route::get('/admin/feedbacks/export', [FeedbackController::class, 'export'])->name('feedbacks.export');

    Route::get('/admin/flyers', [FlyerController::class, 'index'])->name('flyers.index');
    Route::post('/admin/flyers', [FlyerController::class, 'store'])->name('flyers.store');
    Route::delete('/admin/flyers/{flyer}', [FlyerController::class, 'destroy'])->name('flyers.destroy');
});

// Route khusus untuk Super Admin
Route::middleware(['auth', 'role:Super Admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('faculties', SuperAdminFacultyController::class);
    Route::resource('users', SuperAdminUserController::class);
});


// ========================================================================
// ROUTE UNTUK KIOSK PUBLIK (DITEMPATKAN DI BAWAH)
// ========================================================================

// Route utama yang cerdas (redirect ke fakultas pertama)
Route::get('/', function () {
    $firstFaculty = Faculty::firstOrFail();
    return redirect()->route('kiosk.show', ['faculty' => $firstFaculty->slug]);
});

// Route dinamis untuk menampilkan Kiosk berdasarkan slug fakultas
// Ini harus menjadi salah satu route terakhir karena "rakus"
Route::get('/{faculty:slug}', [KioskController::class, 'show'])->name('kiosk.show');