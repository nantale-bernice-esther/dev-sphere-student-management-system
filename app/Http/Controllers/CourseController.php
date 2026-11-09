<?php

namespace App\Http\Controllers;

// Needed to catch the error when the database refuses a delete.
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index(Request $request)
    {
        $query = Course::with(['lecturer', 'students']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $courses = $query->latest()->paginate(10)->withQueryString();

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $lecturers = User::role('lecturer')->orderBy('name')->get();

        return view('admin.courses.create', compact('lecturers'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:courses,code',
            'title' => 'required|string',
            'credit_units' => 'required|integer|min:1|max:10',
            'lecturer_id' => 'nullable|exists:users,id',
        ]);

        Course::create($validated);

        return redirect()->route('administrator.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified course.
     */
    public function show(string $id)
    {
        $course = Course::with(['students.user', 'lecturer'])->findOrFail($id);

        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        $lecturers = User::role('lecturer')->orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'lecturers'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                Rule::unique('courses', 'code')->ignore($course->id),
            ],
            'title' => 'required|string',
            'credit_units' => 'required|integer|min:1|max:10',
            'lecturer_id' => 'nullable|exists:users,id',
        ]);

        $course->update($validated);

        return redirect()->route('administrator.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);

        try {
            $course->delete();
        } catch (QueryException $e) {
            return redirect()
                ->route('administrator.courses.index')
                ->with('error', 'This course cannot be deleted because it has related records.');
        }

        return redirect()->route('administrator.courses.index')->with('success', 'Course deleted successfully.');
    }

    public function studentCourses()
    {
        // Find the student currently logged in.
        $student = Student::where('user_id', Auth::id())->firstOrFail();

        // Get all courses and their lecturers.
        $courses = Course::with('lecturer')->paginate(10);

        // Get IDs of courses this student has registered for.
        $registeredIds = $student->courses()->pluck('courses.id')->toArray();

        return view('student.courses', compact('courses', 'registeredIds'));
    }
}
