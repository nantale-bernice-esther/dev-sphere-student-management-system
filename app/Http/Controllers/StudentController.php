<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = Student::with(['user', 'courses']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('student_number', 'like', "%{$search}%")
                    ->orWhere('programme', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created student in storage.
     *
     * If an account with this email already exists it is reused (and given the
     * student role) instead of rejected, so staff can attach a student profile
     * to an account the person created themselves.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_number' => 'required|string|max:50|unique:students,student_number',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'programme' => 'required|string|max:100',
            'year_of_study' => 'required|integer|min:1|max:4',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user) {
            if (Student::where('user_id', $user->id)->exists()) {
                return back()
                    ->withInput()
                    ->withErrors(['email' => 'A student with this email already exists.']);
            }

            if ($user->hasAnyRole(['administrator', 'lecturer'])) {
                return back()
                    ->withInput()
                    ->withErrors(['email' => 'This email belongs to a staff account.']);
            }

            $user->assignRole('student');
        } else {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make(Str::random(40)),
            ]);

            $user->assignRole('student');
        }

        Student::create([
            'user_id' => $user->id,
            'student_number' => $validated['student_number'],
            'programme' => $validated['programme'],
            'year_of_study' => $validated['year_of_study'],
        ]);

        return redirect()
            ->route('administrator.students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load(['user', 'courses.lecturer']);

        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $student->load('user');

        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('students', 'student_number')->ignore($student->id),
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($student->user_id),
            ],
            'programme' => 'required|string|max:100',
            'year_of_study' => 'required|integer|min:1|max:4',
        ]);

        DB::transaction(function () use ($validated, $student) {
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $student->update([
                'student_number' => $validated['student_number'],
                'programme' => $validated['programme'],
                'year_of_study' => $validated['year_of_study'],
            ]);
        });

        return redirect()
            ->route('administrator.students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        try {
            DB::transaction(function () use ($student) {
                $user = $student->user;
                $student->delete();
                if ($user) {
                    $user->delete();
                }
            });
        } catch (QueryException $e) {
            return redirect()
                ->route('administrator.students.index')
                ->with('error', 'This student cannot be deleted because they have related records.');
        }

        return redirect()
            ->route('administrator.students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
