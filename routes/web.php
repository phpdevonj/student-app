<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Student
    Route::get('/student', [StudentController::class, 'list'])->name('student');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');

    // Availability
    Route::get('/availability', [AvailabilityController::class, 'get'])->name('availability');
    Route::post('/availability', [AvailabilityController::class, 'update'])->name('availability.update');

    // Schedules
    Route::get('/schedules', [ScheduleController::class, 'list'])->name('schedules');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
});

require __DIR__ . '/auth.php';
