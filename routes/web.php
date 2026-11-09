<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegistrationController;
//imporrt student controller
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
// Import the course controller so the route can find it.
use App\Http\Controllers\CourseController;
// Import the lecturer controller so the routes below can find it.
use App\Http\Controllers\LecturerController;
// Public: anyone can open this page (your existing route)
Route::get('/', [AdminController::class, 'home']);

// Authentication: only logged-in users reach /home, which then sends them to the dashboard for their role
Route::get('/home', [AdminController::class, 'index'])->middleware('auth')->name('home');

// Authentication + authorization: logged in AND has the administrator role (anyone else gets a 403)
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('administrator.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    // Admin routes for students, courses and registrations go here
    //routes for student crud operations
    Route::resource('students', StudentController::class);

        // Routes for course CRUD operations (list, add, view, edit, delete).
    // One line like this creates all 7 routes  same as for students.
    Route::resource('courses', CourseController::class);
    // Routes for registrations (list, add, delete).
// Route::resource normally makes 7 routes for one controller.
// only([...]) keeps just the 4 we need:
//   index   = show the list
//   create  = show the empty add form
//   store   = save the new registration
//   destroy = delete a registration
// We leave out edit and update because a registration is never edited:
// if it is wrong, the admin deletes it and adds a new one.
Route::resource('registrations', RegistrationController::class)->only(['index', 'create', 'store', 'destroy']);
    
    
    });

// Authentication + authorization: logged in AND has the lecturer role
Route::middleware(['auth', 'role:lecturer'])->prefix('lecturer')->name('lecturer.')->group(function () {
    Route::get('/dashboard', fn () => view('lecturer.dashboard'))->name('dashboard');

    // Lecturer routes (assigned courses and their registered students) go here
        // "My courses": the courses assigned to the logged-in lecturer.
    Route::get('/courses', [LecturerController::class, 'courses'])->name('courses');

    // The students registered on one course. {id} is the course number in the address.
    Route::get('/courses/{id}/students', [LecturerController::class, 'courseStudents'])->name('courses.students');
});


// Authentication + authorization: logged in AND has the student role
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', fn () => view('student.dashboard'))->name('dashboard');

    // Student routes (available courses and own registrations) go here
});


// These two routes show which courses a student takes and which students
// take a course (Question 1c). Before, anyone could open them by typing the
// address, even without logging in. Now only a logged-in administrator can.
// There is no prefix, so the addresses stay exactly the same as before.
Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/students/{student}/courses', [RegistrationController::class, 'studentCourses']);
    Route::get('/courses/{course}/students', [RegistrationController::class, 'courseStudents']);
});

