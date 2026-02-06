<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\JobSearchController;
use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\UserController;


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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});

// Job Offers (recruteur only)
Route::middleware(['auth', 'verified', 'role:recruteur'])->prefix('job-offers')->name('job-offers.')->group(function () {
    Route::get('/', [JobOfferController::class, 'index'])->name('index');
    Route::get('/create', [JobOfferController::class, 'create'])->name('create');
    Route::post('/', [JobOfferController::class, 'store'])->name('store');
    Route::get('/{jobOffer}/edit', [JobOfferController::class, 'edit'])->name('edit');
    Route::patch('/{jobOffer}', [JobOfferController::class, 'update'])->name('update');
    Route::post('/{jobOffer}/close', [JobOfferController::class, 'close'])->name('close');
    Route::delete('/{jobOffer}', [JobOfferController::class, 'destroy'])->name('destroy');
    Route::get('/{jobOffer}/applications', [JobOfferController::class, 'applications'])->name('applications');
});

// CV Management (chercheur only)
Route::middleware(['auth', 'verified', 'role:chercheur'])->prefix('cv')->name('cv.')->group(function () {
    Route::get('/', [CvController::class, 'show'])->name('show');
    Route::get('/edit', [CvController::class, 'edit'])->name('edit');
});

// Job Search (chercheur only)
Route::middleware(['auth', 'verified', 'role:chercheur'])->group(function () {
    Route::get('/jobs', [JobSearchController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{jobOffer}', [JobSearchController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{jobOffer}/apply', [JobSearchController::class, 'apply'])->name('jobs.apply');
    Route::get('/my-applications', [JobSearchController::class, 'myApplications'])->name('applications.my');
});

require __DIR__.'/auth.php';

