<?php

namespace App\Http\Controllers;
//import student model
use App\Models\Student;
//import user model
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    //->paginate(10);retrieves students in pages of 10
    {
      $students = Student::with('user')->paginate(10);

    return view('admin.students.index', compact('students'));
    //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //please when this function runs display the create views
            return view('admin.students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
  // STORE: runs when the admin clicks Save on the Add student form.
// Its job: check the data, then save a new student.
public function store(Request $request)
{
    // Rule check. If a rule fails, Laravel returns to the form with the problems.
    // Notice there is NO "unique" rule on the email here. A person may already
    // have an account (they signed up themselves), so we check the email
    // ourselves in the steps below.
    $validated = $request->validate([
        'student_number' => 'required|unique:students,student_number',
        'name'           => 'required|string',
        'email'          => 'required|email',
        'programme'      => 'required|string',
        'year_of_study'  => 'required|integer|min:1|max:4',
    ]);

    // Look in the users table for an account with this email.
    // first() gives us that user, or nothing if there is none.
    $user = User::where('email', $validated['email'])->first();

    if ($user) {
        // An account exists. Is this person already a student?
        // We look in the students table for a profile linked to this user.
        if (Student::where('user_id', $user->id)->exists()) {
            // Go back to the form, keep what was typed, and show an error.
            return back()
                ->withInput()
                ->withErrors(['email' => 'A student with this email already exists.']);
        }

        // Is the account an administrator or a lecturer? Those accounts must
        // not be turned into students by mistake.
        if ($user->hasAnyRole(['administrator', 'lecturer'])) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'This email belongs to a staff account.']);
        }

        // The account is free to use. Make sure it has the student role.
        // We do NOT change its password or name: the person chose those
        // themselves when they signed up.
        $user->assignRole('student');
    } else {
        // No account yet, so create one, as before.
        // The random password means the student must reset it before logging in.
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make(Str::random(40)),
        ]);
        $user->assignRole('student');
    }

    // Save the student profile (number, programme, year) and link it to the
    // account with user_id. This is the row that was missing for her.
    Student::create([
        'user_id'        => $user->id,
        'student_number' => $validated['student_number'],
        'programme'      => $validated['programme'],
        'year_of_study'  => $validated['year_of_study'],
    ]);

    // Go back to the list with a green success message.
    return redirect()
        ->route('administrator.students.index')
        ->with('success', 'Student created successfully.');
}

    /**
     * Display the specified resource.
     */
   public function show(string $id)
{
    // $id is the number in the address. For /students/5, $id is 5.
    // Ask the database for the student with that id.
    // with('user') also brings the name and email, which are stored in the users table.
    $student = Student::with('user')->find($id);

    // Open the show page and hand it the student to display.
    return view('admin.students.show', compact('student'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
         // $id is the number in the address. For /students/5/edit, $id is 5.
    // Find that student, together with their user account (name and email).
    $student = Student::with('user')->find($id);

    // Open the edit page and give it the student, so the form can be filled in.
    return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    // Find the student being edited, with their user account.
    $student = Student::with('user')->find($id);

    // Check the submitted data, as in store().
    // The extra part after the comma means "ignore this student's own row".
    // Without it, saving without changing the email would fail,
    // because the email would match... itself.
    $validated = $request->validate([
        'student_number' => 'required|unique:students,student_number,' . $student->id,
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $student->user_id,
        'programme' => 'required|string',
        'year_of_study' => 'required|integer|min:1|max:4',
    ]);

    // The name and email are stored in the users table.
    $student->user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);

    // The other details are stored in the students table.
    $student->update([
        'student_number' => $validated['student_number'],
        'programme' => $validated['programme'],
        'year_of_study' => $validated['year_of_study'],
    ]);

    // Go back to the list with a success message.
    return redirect()
        ->route('administrator.students.index')
        ->with('success', 'Student updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
        public function destroy(string $id)
    {
        // Find the student we want to remove, together with their user account.
      // Find the student being deleted, together with their user account.
    $student = Student::with('user')->find($id);

    // try means: "attempt this". If the database refuses,
    // the code inside catch runs instead of the page crashing.
    try {
        // A student is saved in two tables, so we remove both:
        // first the student record, then their login account.
        $user = $student->user;
        $student->delete();
        $user->delete();
    } catch (\Illuminate\Database\QueryException $e) {
        // The database said no, for example because the student has
        // registrations. Go back and show a red error message.
        return redirect()
            ->route('administrator.students.index')
            ->with('error', 'This student cannot be deleted because they have related records.');
    }

    // It worked. Go back to the list with a green message.
    return redirect()
        ->route('administrator.students.index')
        ->with('success', 'Student deleted successfully.');
    }
}
