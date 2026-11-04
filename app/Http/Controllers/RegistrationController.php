<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;


use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function studentCourses(Student $student){
        return $student->courses;

    }

    public function courseStudents(Course $course)
    {
        return $course->students;
    }

    //
}
