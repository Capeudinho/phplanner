<?php

use App\Http\Controllers\GoalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\EnsureGoalOwnership;
use App\Http\Middleware\EnsureTaskOwnership;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

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
	Route::resource('task', TaskController::class)->middleware(EnsureTaskOwnership::class);
	Route::resource('goal', GoalController::class)->middleware(EnsureGoalOwnership::class);
});

Route::get('/send-email', [MailController::class, 'sendWeeklyReminderEmail']); // for testing

require __DIR__.'/auth.php';
