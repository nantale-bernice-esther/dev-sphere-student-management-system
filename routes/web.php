<?php

use App\Http\Controllers\Admin\LecturerController as AdminLecturerController;
use App\Http\Controllers\AdminController;
// Import the course controller so the route can find it.
use App\Http\Controllers\CourseController;
// Import the lecturer controller so the routes below can find it.
use App\Http\Controllers\DashboardController;
// The controller that prepares the dashboard data for each role.
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RoleController;
// routes for student crud operations
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserAccessController;
use Illuminate\Support\Facades\Route;

// Public homepage
Route::get('/', [AdminController::class, 'home'])->name('welcome');

// Authentication: only logged-in users reach /home, which then sends them to the dashboard for their role
Route::get('/home', [AdminController::class, 'index'])->middleware('auth')->name('home');

// Administrator Routes
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('administrator.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    // Admin routes for students, courses and registrations go here
    Route::resource('students', StudentController::class);

    // Routes for course CRUD operations (list, add, view, edit, delete).
    Route::resource('courses', CourseController::class);

    // Routes for registrations (list, add, delete). A registration is never
    // edited: if it is wrong, the admin deletes it and adds a new one.
    Route::resource('registrations', RegistrationController::class)->only(['index', 'create', 'store', 'destroy']);

    // Lecturer account management (list, add, edit, delete).
    Route::resource('lecturers', AdminLecturerController::class)->except(['show']);

    // Role/permission matrix and per-user role assignment.
    Route::put('/roles', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::put('/users/{user}', [UserAccessController::class, 'update'])->name('users.update');
    Route::get('/users', [UserAccessController::class, 'index'])->name('users.index');
});

// Authentication + authorization: logged in AND has the lecturer role
Route::middleware(['auth', 'role:lecturer'])->prefix('lecturer')->name('lecturer.')->group(function () {
    // Open the lecturer dashboard. The DashboardController gets the lecturer's
    // courses and student registration counts from the database.
    Route::get('/dashboard', [DashboardController::class, 'lecturer'])->name('dashboard');

    // "My courses": the courses assigned to the logged-in lecturer.
    Route::get('/courses', [LecturerController::class, 'index'])->name('courses');

    // Display students registered for a course assigned to the lecturer.
    Route::get('/courses/{id}/students', [LecturerController::class, 'show'])->name('courses.students');
});

// Shared dashboards: every authenticated user gets /dashboard resolved by role,
// so login can always redirect there regardless of which role the account has.
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('administrator')) {
            return view('admin.dashboard');
        }

        if ($user->hasRole('lecturer')) {
            return app(DashboardController::class)->lecturer();
        }

        return view('student.dashboard');
    })->name('dashboard');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', fn () => view('student.dashboard'))->name('dashboard');
    Route::get('/courses', [RegistrationController::class, 'availableCourses'])->name('courses');
    Route::get('/register', [RegistrationController::class, 'studentRegister'])->name('register');
    Route::post('/register', [RegistrationController::class, 'studentStore'])->name('register.store');
    Route::get('/registrations', [RegistrationController::class, 'studentRegistrations'])->name('registrations');
});

// These two routes show which courses a student takes and which students
// take a course (Question 1c). Before, anyone could open them by typing the
// address, even without logging in. Now only a logged-in administrator can.
// There is no prefix, so the addresses stay exactly the same as before.
Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/students/{student}/courses', [RegistrationController::class, 'studentCourses']);
    Route::get('/courses/{course}/students', [RegistrationController::class, 'courseStudents']);
});

// Unprefixed aliases keep every existing link and form target working while
// the admin screens live under /admin with administrator.* names.
Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::controller(StudentController::class)->group(function () {
        Route::get('/students', 'index')->name('students.index');
        Route::get('/students/create', 'create')->name('students.create');
        Route::post('/students', 'store')->name('students.store');
        Route::get('/students/{student}', 'show')->name('students.show');
        Route::get('/students/{student}/edit', 'edit')->name('students.edit');
        Route::put('/students/{student}', 'update')->name('students.update');
        Route::patch('/students/{student}', 'update')->name('students.patch');
        Route::delete('/students/{student}', 'destroy')->name('students.destroy');
    });

    Route::controller(CourseController::class)->group(function () {
        Route::get('/courses', 'index')->name('courses.index');
        Route::get('/courses/create', 'create')->name('courses.create');
        Route::post('/courses', 'store')->name('courses.store');
        Route::get('/courses/{course}', 'show')->name('courses.show');
        Route::get('/courses/{course}/edit', 'edit')->name('courses.edit');
        Route::put('/courses/{course}', 'update')->name('courses.update');
        Route::patch('/courses/{course}', 'update')->name('courses.patch');
        Route::delete('/courses/{course}', 'destroy')->name('courses.destroy');
    });

    Route::controller(RegistrationController::class)->group(function () {
        Route::get('/registrations', 'index')->name('registrations.index');
        Route::get('/registrations/create', 'create')->name('registrations.create');
        Route::post('/registrations', 'store')->name('registrations.store');
        Route::delete('/registrations/{registration}', 'destroy')->name('registrations.destroy');
    });

    Route::controller(AdminLecturerController::class)->group(function () {
        Route::get('/lecturers', 'index')->name('lecturers.index');
        Route::get('/lecturers/create', 'create')->name('lecturers.create');
        Route::post('/lecturers', 'store')->name('lecturers.store');
        Route::get('/lecturers/{lecturer}/edit', 'edit')->name('lecturers.edit');
        Route::put('/lecturers/{lecturer}', 'update')->name('lecturers.update');
        Route::patch('/lecturers/{lecturer}', 'update')->name('lecturers.patch');
        Route::delete('/lecturers/{lecturer}', 'destroy')->name('lecturers.destroy');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index')->name('roles.index');
        Route::put('/roles', 'update')->name('roles.update');
    });

    Route::controller(UserAccessController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::put('/users/{user}', 'update')->name('users.update');
    });
});
