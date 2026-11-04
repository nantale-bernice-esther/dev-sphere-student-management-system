<?php
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students/{student}/courses', [RegistrationController::class, 'studentCourses']);
Route::get('/courses/{course}/students', [RegistrationController::class, 'courseStudents']);



