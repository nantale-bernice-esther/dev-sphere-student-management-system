<?php

namespace App\Http\Controllers;

use App\Models\Course;

class LecturerCourseController extends Controller
{
    /**
     * Display courses assigned to the authenticated lecturer.
     */
    public function index()
    {
        $courses = Course::where('lecturer_id', auth()->id())
            ->withCount('students')
            ->orderBy('code')
            ->paginate(10);

        return view('lecturer.courses', compact('courses'));
    }

    /**
     * Display the student roster for a lecturer's assigned course.
     */
    public function students(Course $course)
    {
        // Prevent unauthorized access to other lecturers' courses
        if ($course->lecturer_id !== auth()->id() && ! auth()->user()->hasRole('administrator')) {
            abort(403, 'Unauthorized access to course roster.');
        }

        $students = $course->students()->with('user')->paginate(15);

        return view('lecturer.course-students', compact('course', 'students'));
    }
}
