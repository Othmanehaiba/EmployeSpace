<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendRequestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/friends/request/{user}', [FriendRequestController::class, 'send'])->name('friends.request.send');
    Route::post('/friends/request/{friendRequest}/accept', [FriendRequestController::class, 'accept'])->name('friends.request.accept');
    Route::post('/friends/request/{friendRequest}/reject', [FriendRequestController::class, 'reject'])->name('friends.request.reject');
});

require __DIR__.'/auth.php';
