<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Public: anyone can open this page (your existing route)
Route::get('/', [AdminController::class, 'home']);

// Authentication: only logged-in users reach /home, which then sends them to the dashboard for their role
Route::get('/home', [AdminController::class, 'index'])->middleware('auth')->name('home');

// Authentication + authorization: logged in AND has the administrator role (anyone else gets a 403)
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('administrator.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    // Admin routes for students, courses and registrations go here
});

// Authentication + authorization: logged in AND has the lecturer role
Route::middleware(['auth', 'role:lecturer'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('/dashboard', fn () => view('lecturer.dashboard'))->name('dashboard');

    // Lecturer routes (assigned courses and their registered students) go here
});

// Authentication + authorization: logged in AND has the student role
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', fn () => view('student.dashboard'))->name('dashboard');

    // Student routes (available courses and own registrations) go here
});
Route::get('/students/{student}/courses', [RegistrationController::class, 'studentCourses']);
Route::get('/courses/{course}/students', [RegistrationController::class, 'courseStudents']);



