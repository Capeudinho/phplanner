<?php

use App\Http\Controllers\GoalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\EnsureCategoryOwnership;
use App\Http\Middleware\EnsureGoalOwnership;
use App\Http\Middleware\EnsureTaskOwnership;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
})->middleware('guest'); 

Route::get('/dashboard', [GoalController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	Route::resource('task', TaskController::class)->middleware(EnsureTaskOwnership::class);
	Route::resource('goal', GoalController::class)->middleware(EnsureGoalOwnership::class);
	Route::resource('category', CategoryController::class)->middleware(EnsureCategoryOwnership::class);
	Route::resource('report', ReportController::class)->only(['index']);
	Route::get('/goals/filter/{status}', [GoalController::class, 'filterByStatus'])->middleware('auth')->name('goals.filter');


	// rotas do fullcalendar
	Route::get('/events', [TaskController::class, 'events']); 
});

require __DIR__.'/auth.php';