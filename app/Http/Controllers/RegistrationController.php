<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
// Import the Registration model.
// A "model" is the PHP class that represents one database table.
// The registrations table joins a student to a course, so this model
// lets us read those rows. Without this line, PHP would not know what
// "Registration" means when we use it further down.
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller{


    public function studentRegistrations(){

        // Find the student profile belonging to the logged-in user.
        $student = Student::where('user_id', Auth::id())->firstOrFail();

        // Retrieve only this student's registrations.
        $registrations = Registration::with('course.lecturer')
            ->where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        // Display the student's registrations.
        return view('student.registrations', compact('registrations'));
    }





    public function studentCourses(Student $student){
        return $student->courses;

    }

    public function courseStudents(Course $course)
    {
        return $course->students;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    // Registration::with(...)->paginate(10) means:
    //   - get registrations from the database
    //   - 10 per page, so a long list does not fill the screen
    //
    // A registration only stores ID numbers (student_id and course_id).
    // with(...) tells Laravel to also fetch the real records those IDs
    // point to, so the page can show names instead of numbers:
    //   'student.user' = the registration's student, and that student's
    //                    user account (the student's name is stored there)
    //   'course'       = the registration's course (code and title)
    $registrations = Registration::with('student.user', 'course')->paginate(10);

        // The controller only fetches data. It cannot show anything on the screen.
// So the last step is to hand the registrations over to the page that
// will display them.
//
// 'admin.registrations.index' = which page to open. The dots stand for
// folders, so it means resources/views/admin/registrations/index.blade.php
//
// compact('registrations') = the data to carry to that page. On the page it
// is called $registrations, and the page loops over it with @forelse to
// make one table row for each registration.
return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     */

    // CREATE: runs when the admin clicks "Add registration".
// Its job: show the empty form. The form needs two dropdowns, one full of
// students and one full of courses, so we fetch both lists here.

    
    
    public function create()
    {
        //

    // Get every student, together with their user account, because the
    // student's name is stored in the users table.
    $students = Student::with('user')->get();

    // Get every course.
    $courses = Course::all();

    // Open the add page and hand it both lists, so the dropdowns can show them.
    return view('admin.registrations.create', compact('students', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     
     */


    // STORE: runs when the admin clicks Save on the form.
// Its job: check the data, refuse duplicates, then save the registration
    public function store(Request $request)
    {
        //

    // Rule check. If a rule fails, Laravel goes back to the form and
    // lists the problems.
    //   required = must not be empty
    //   exists   = the id must belong to a real row in that table, so nobody
    //              can register a student or course that does not exist
    $validated = $request->validate([
        'student_id' => 'required|exists:students,id',
        'course_id'  => 'required|exists:courses,id',
        'semester'   => 'required|string|max:50',
    ]);

    // Duplicate check. We ask the database: "is there already a registration
    // with this same student, course and semester?" exists() answers yes or no.
    $alreadyRegistered = Registration::where('student_id', $validated['student_id'])
        ->where('course_id', $validated['course_id'])
        ->where('semester', $validated['semester'])
        ->exists();

    // If it is a duplicate, go back to the form, keep what the admin chose
    // (withInput), and show a red error message. Nothing is saved.
    if ($alreadyRegistered) {
        return back()
            ->withInput()
            ->with('error', 'This student is already registered for this course in this semester.');
    }

    // Not a duplicate, so save the new registration in the database.
    Registration::create($validated);

    // Go back to the list with a green success message.
    return redirect()
        ->route('administrator.registrations.index')
        ->with('success', 'Registration saved successfully.');
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
    
    // Find the registration the admin wants to remove.
        $registration = Registration::findOrFail($id);

        // Delete that one row. The student and the course stay.
        $registration->delete();

        // Go back to the list with a green success message.
        return redirect()
            ->route('administrator.registrations.index')
            ->with('success', 'Registration removed successfully.');
    }
}
