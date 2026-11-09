<?php

namespace App\Http\Controllers;

use App\Models\Course;
// Import the Course model so we can read courses from the database.
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // INDEX: shows the courses assigned to the lecturer who is logged in.
    public function index()
    {

        // auth()->id() is the id of the person logged in right now.
        // where('lecturer_id', ...) keeps only courses assigned to that person.
        // withCount('students') counts the registered students for each course.
        $courses = Course::where('lecturer_id', auth()->id())
            ->withCount('students')
            ->get();

        // Open the lecturer courses page and hand it the courses.
        return view('lecturer.courses', compact('courses'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the selected course and retrieve its registered students.
        $course = Course::with('lecturer')->findOrFail($id);

        // Make sure the lecturer can only view students in their own course.
        abort_unless($course->lecturer_id == auth()->id(), 403);

        $students = $course->students()->with('user')->paginate(15);

        // Open the course students page and send it the course information.
        return view('lecturer.course-students', compact('course', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
