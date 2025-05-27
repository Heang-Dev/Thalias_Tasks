<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('students', StudentController::class);

Route::patch('students/{student}/status', [StudentController::class, 'updateStatus'])->name('students.update-status');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
