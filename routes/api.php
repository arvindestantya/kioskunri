<?php

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GuestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/faculties/{faculty}/guests', [GuestController::class, 'store']);
Route::post('/faculties/{faculty}/feedbacks', [FeedbackController::class, 'store']);
Route::post('/faculties/{faculty}/surveys', [SurveyController::class, 'store']);
Route::get('/guests/search/{no_identitas}', [GuestController::class, 'searchByNoIdentitas']);

// Route::get('/faculties/{faculty}/flyers', function (Faculty $faculty) {
//     return response()->json([
//         'flyers' => $faculty->flyers()->latest()->get()->pluck('path')
//     ]);
// });