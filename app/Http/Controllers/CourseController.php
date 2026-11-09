<?php


namespace App\Http\Controllers;
// Needed to catch the error when the database refuses a delete.
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
// Import the Course model so we can read courses from the database.
use App\Models\Course;
// Import the User model, because a lecturer is a user.
use App\Models\User;
use App\Models\Student;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
        // Get the courses from the database, 10 per page.
        // with('lecturer') also brings each course's lecturer in one go,
        // so we can show the lecturer's name in the table.
        $courses = Course::with('lecturer')->paginate(10);

        // Open the courses list page and give it the courses.
        return view('admin.courses.index', compact('courses'));  //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Get all users who have the "lecturer" role.
    // They will fill the lecturer dropdown on the form.
    $lecturers = User::role('lecturer')->get();

    // Open the add-course page and give it the lecturers.
    return view('admin.courses.create', compact('lecturers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // Check the submitted data. If a rule fails, Laravel goes back
    // to the form and shows the errors.
    
   

   
    
    $validated = $request->validate([
        // required = must not be empty.
        // unique:courses,code = no other course may have this code.
        'code' => 'required|string|unique:courses,code',
        'title' => 'required|string',
        // must be a whole number between 1 and 10
        'credit_units' => 'required|integer|min:1|max:10',
        // the lecturer is optional (nullable), but if one is chosen,
        // it must exist in the users table.
        'lecturer_id' => 'nullable|exists:users,id',
    ]);

    // Save the new course in the database.
    Course::create($validated);

    // Go back to the courses list with a success message.
    return redirect()
        ->route('administrator.courses.index')
        ->with('success', 'Course created successfully.');   //
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
    // $id is the number in the address. For /courses/5/edit, $id is 5.
    // Find the course with that id.
    $course = Course::find($id);

    // Get all the lecturers, to fill the lecturer dropdown.
    $lecturers = User::role('lecturer')->get();

    // Open the edit page and give it the course and the lecturers.
    return view('admin.courses.edit', compact('course', 'lecturers'));     //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         // Find the course that is being edited.
    $course = Course::find($id);

    // Check the submitted data, as in store().
    // The extra part after the comma means "ignore this course's own row".
    // Without it, saving a course without changing its code would fail,
    // because the code would match itself.
    $validated = $request->validate([
        'code' => 'required|string|unique:courses,code,' . $course->id,
        'title' => 'required|string',
        'credit_units' => 'required|integer|min:1|max:10',
        'lecturer_id' => 'nullable|exists:users,id',
    ]);

    // Save the changes into the database.
    $course->update($validated);

    // Go back to the list with a success message.
    return redirect()
        ->route('administrator.courses.index')
        ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

    // Find the course that is being deleted.
    $course = Course::find($id);

    // try means: "attempt this". If the database refuses, the code in
    // catch runs instead of the page crashing.
    try {
        $course->delete();
    } catch (QueryException $e) {
        // The database said no, for example because students are registered
        // on this course. Go back and show a red error message.
        return redirect()
            ->route('administrator.courses.index')
            ->with('error', 'This course cannot be deleted because it has related records.');
    }

    // The delete worked. Go back to the list with a green message.
    return redirect()
        ->route('administrator.courses.index')
        ->with('success', 'Course deleted successfully.');
    }

    public function studentCourses()
    {
        // Find the student currently logged in.
        $student = Student::where('user_id', Auth::id())
            ->firstOrFail();

        // Get all courses and their lecturers.
        $courses = Course::with('lecturer')->paginate(10);

        // Get IDs of courses this student has registered for.
        $registeredIds = $student->courses()
            ->pluck('courses.id')
            ->toArray();

        return view('student.courses', compact(
            'courses',
            'registeredIds'
        ));
    }
}
