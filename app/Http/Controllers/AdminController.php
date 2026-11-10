<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// Import the Course model so we can get the lecturer's courses from the database.
use App\Models\Course;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        
        //hasrole
        if ($user->hasRole('administrator')) {
            return view('admin.dashboard');
        
} elseif ($user->hasRole('lecturer')) {

    // Get the courses assigned to the logged-in lecturer.
    // Also count the students registered for each course.
    $assignedCourses = Course::where('lecturer_id', $user->id)
        ->withCount('students')
        ->get();

    // Count the total courses assigned to this lecturer.
    $courseCount = $assignedCourses->count();

    // Count all student registrations across the lecturer's courses.
    $studentCount = $assignedCourses->sum('students_count');

    // Send all dashboard data to the lecturer dashboard.
    return view('lecturer.dashboard', compact(
        'assignedCourses',
        'courseCount',
        'studentCount'
    ));
}
elseif ($user->hasRole('student')) {
            return view('student.dashboard');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function home()
    {
        return view('index');
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
