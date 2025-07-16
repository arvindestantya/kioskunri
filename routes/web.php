<?php

use App\Models\Faculty;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FlyerController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminDashboardController;
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
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/admin/guests', [GuestController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('guests');
Route::get('/admin/feedbacks', [FeedbackController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('feedbacks');
Route::get('/admin/surveys', [SurveyController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('surveys');

// Include route autentikasi dari Breeze (login, register, dll.)
// Ini harus diproses SEBELUM route dinamis {faculty:slug}
require __DIR__.'/auth.php';

// Route untuk area profile yang dibuat oleh Breeze
Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk fitur yang bisa diakses semua admin
Route::middleware(['auth', 'verified'])->group(function() {
    Route::delete('/admin/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
    Route::get('/admin/guests/export', [GuestController::class, 'export'])->name('guests.export');
    Route::delete('/admin/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');
    Route::get('/admin/feedbacks/export', [FeedbackController::class, 'export'])->name('feedbacks.export');
    Route::delete('/admin/surveys/{survey}', [SurveyController::class, 'destroy'])->name('surveys.destroy');
    Route::get('/admin/surveys/export', [SurveyController::class, 'export'])->name('surveys.export');

    Route::get('/admin/flyers', [FlyerController::class, 'index'])->name('flyers.index');
    Route::post('/admin/flyers', [FlyerController::class, 'store'])->name('flyers.store');
    Route::delete('/admin/flyers/{flyer}', [FlyerController::class, 'destroy'])->name('flyers.destroy');
    
    Route::resource('admin/contacts', ContactController::class)->names('contacts');
    Route::resource('admin/schedules', ScheduleController::class)->names('schedules');
    Route::resource('admin/maps', MapController::class)->names('maps');
    Route::resource('admin/announcements', AnnouncementController::class)->names('announcements');
    Route::resource('admin/events', EventController::class)->names('events');
    Route::resource('admin/services', ServiceController::class)->names('services');
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