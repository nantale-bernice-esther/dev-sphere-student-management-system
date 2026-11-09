<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Admin: Display a listing of all student course registrations.
     */
    public function index(Request $request)
    {
        $query = Registration::with(['student.user', 'course.lecturer']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('semester', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($sq) use ($search) {
                        $sq->where('student_number', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($uq) use ($search) {
                                $uq->where('name', 'like', "%{$search}%");
                            });
                    })
                    ->orWhereHas('course', function ($cq) use ($search) {
                        $cq->where('code', 'like', "%{$search}%")
                            ->orWhere('title', 'like', "%{$search}%");
                    });
            });
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Admin: Show the form for creating a new registration.
     */
    public function create()
    {
        $students = Student::with('user')->get();
        $courses = Course::with('lecturer')->orderBy('code')->get();

        return view('admin.registrations.create', compact('students', 'courses'));
    }

    /**
     * Admin: Store a newly created registration.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|string|max:50',
        ]);

        // Duplicate prevention check
        $exists = Registration::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->where('semester', $validated['semester'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'This student is already registered for this course in the selected semester.');
        }

        Registration::create($validated);

        return redirect()->route('administrator.registrations.index')->with('success', 'Student registered for course successfully.');
    }

    /**
     * Admin: Remove a course registration.
     */
    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()->route('administrator.registrations.index')->with('success', 'Registration removed successfully.');
    }

    /**
     * Student: Display catalog of available courses.
     */
    public function availableCourses()
    {
        $courses = Course::with('lecturer')->orderBy('code')->get();

        $student = auth()->user()->student;
        $registeredCourseIds = $student ? $student->courses->pluck('id') : collect();

        return view('student.courses', compact('courses', 'registeredCourseIds'));
    }

    /**
     * Student: Show course registration form.
     */
    public function studentRegister(Request $request)
    {
        $courses = Course::with('lecturer')->orderBy('code')->get();

        return view('student.register', compact('courses'));
    }

    /**
     * Student: Submit self-registration.
     */
    public function studentStore(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|string|max:50',
        ]);

        $student = auth()->user()->student;
        if (! $student) {
            return back()->with('error', 'No student academic profile found for your account.');
        }

        // Duplicate registration prevention check
        $exists = Registration::where('student_id', $student->id)
            ->where('course_id', $validated['course_id'])
            ->where('semester', $validated['semester'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'You are already registered for this course in this semester.');
        }

        Registration::create([
            'student_id' => $student->id,
            'course_id' => $validated['course_id'],
            'semester' => $validated['semester'],
        ]);

        return redirect()->route('student.registrations')->with('success', 'You have successfully enrolled in the course.');
    }

    /**
     * Student: Display own registrations.
     */
    public function studentRegistrations()
    {
        $student = auth()->user()->student;
        $registrations = $student
            ? $student->registrations()->with('course.lecturer')->latest()->paginate(10)
            : collect();

        return view('student.registrations', compact('registrations'));
    }

    /**
     * API / Helper: Retrieve a student's registered courses.
     */
    public function studentCourses(Student $student)
    {
        return $student->courses;
    }

    /**
     * API / Helper: Retrieve students registered for a course.
     */
    public function courseStudents(Course $course)
    {
        return $course->students;
    }
}
