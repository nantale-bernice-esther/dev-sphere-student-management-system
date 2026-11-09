<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Import the Course model.
// We use this model to get course information from the database.
use App\Models\Course;
use App\Models\Student;
use App\Models\Registration;

class DashboardController extends Controller
{




    /**
     * Display the lecturer dashboard.
     *
     * This method gets the information that the lecturer
     * needs to see when they open their dashboard.
     */
    public function lecturer()
    {
        // STEP 1:
        // Get the ID of the lecturer who is currently logged in.
        // auth()->id() gives us the ID of the logged-in user.
        //
        // STEP 2:
        // Look in the courses table for courses assigned
        // to this lecturer.
        //
        // lecturer_id is the column that connects a course
        // to the lecturer responsible for teaching it.
        //
        // STEP 3:
        // withCount('students') counts the students registered
        // for each course.
        //
        // STEP 4:
        // get() retrieves the matching courses from the database
        // and stores them in the $assignedCourses variable.
        $assignedCourses = Course::where('lecturer_id', Auth::id())
            ->withCount('students')
            ->get();

        // Count how many courses belong to this lecturer.
        // count() counts the courses retrieved above.
        // The result is stored in $courseCount.
        $courseCount = $assignedCourses->count();

        // Add the student registration counts from all
        // the lecturer's courses together.
        //
        // students_count is created by withCount('students').
        // sum() adds those counts to get the total.
        $studentCount = $assignedCourses->sum('students_count');

        // Open the lecturer dashboard Blade file.
        // Send the course information and dashboard totals
        // so the page can display real database information.
        //
        // compact() creates an array containing these variables
        // and passes that array to the dashboard page.
        return view('lecturer.dashboard', compact(
            'assignedCourses',
            'courseCount',
            'studentCount'
        ));
    }

    /**
 * Display the student dashboard.
 */
public function student()
{
    // Get the currently logged-in student.
    $student = Student::where('user_id', Auth::id())
        ->firstOrFail();

    // Get the student's registrations.
    $registrations = Registration::with('course')
        ->where('student_id', $student->id)
        ->get();

    // Count registered courses.
    $registrationCount = $registrations->count();

    // Count all available courses.
    $availableCount = Course::count();

    return view('student.dashboard', compact(
        'student',
        'registrations',
        'registrationCount',
        'availableCount'
    ));
}


    













    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        //
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
