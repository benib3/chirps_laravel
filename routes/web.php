<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ChatController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('chirps', ChirpController::class)
    ->only(['index','store','update','edit','destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('chirp.comments', CommentController::class)
    ->only(['index','create','store','destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('chirp.likes', LikeController::class)
    ->only(['store','destroy'])
    ->middleware(['auth', 'verified']);

// Trying route in a different way
Route::prefix('chirps')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chirps.chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chirps.chat.show');
    Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chirps.chat.store');
})->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
