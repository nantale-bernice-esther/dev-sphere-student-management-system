<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LecturerCourseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Public homepage
Route::get('/', [AdminController::class, 'home'])->name('welcome');

// Authentication entry point: redirects to dashboard for user's role
Route::get('/home', [AdminController::class, 'index'])->middleware('auth')->name('home');

// Administrator Routes
Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/admin/dashboard', fn () => view('admin.dashboard'))->name('administrator.dashboard');

    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('registrations', RegistrationController::class)->except(['show', 'edit', 'update']);
});

// Lecturer Routes
Route::middleware(['auth', 'role:lecturer'])->prefix('lecturer')->group(function () {
    Route::get('/dashboard', fn () => view('lecturer.dashboard'))->name('lecturer.dashboard');
    Route::get('/courses', [LecturerCourseController::class, 'index'])->name('lecturer.courses');
    Route::get('/courses/{course}/students', [LecturerCourseController::class, 'students'])->name('lecturer.course.students');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', fn () => view('student.dashboard'))->name('student.dashboard');
    Route::get('/courses', [RegistrationController::class, 'availableCourses'])->name('student.courses');
    Route::get('/register', [RegistrationController::class, 'studentRegister'])->name('student.register');
    Route::post('/register', [RegistrationController::class, 'studentStore'])->name('student.register.store');
    Route::get('/registrations', [RegistrationController::class, 'studentRegistrations'])->name('student.registrations');
});

// API / Relationship Verification endpoints
Route::get('/students/{student}/courses', [RegistrationController::class, 'studentCourses']);
Route::get('/courses/{course}/students', [RegistrationController::class, 'courseStudents']);
