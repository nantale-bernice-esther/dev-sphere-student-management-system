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
    public function store(Request $request)
    {
        //receives info submitted in the form
        //requred eans must not be empty
        $validated = $request->validate([
            //validate checks whether the information meets the rules
        'student_number' => 'required|unique:students,student_number',
        'name' => 'required|string',
        //the email must not already exist in the database
        'email' => 'required|email|unique:users,email',
        'programme' => 'required|string',
        //year of study must be btn 1 and 4 yrs
        'year_of_study' => 'required|integer|min:1|max:4',
    ]);

    //creates user account
$user = User::create([
    'name' => $validated['name'],
    'email' => $validated['email'],
    //creates a secure random password hash bu currently the form doesnt collect password
    //so they will need a password reset before logging in
    'password' => Hash::make(Str::random(40)),
]);
//assigns student role
$user->assignRole('student');

Student::create([
    'user_id' => $user->id,
    'student_number' => $validated['student_number'],
    'programme' => $validated['programme'],
    'year_of_study' => $validated['year_of_study'],
]);

return redirect()
    ->route('administrator.students.index')
    //sends a success message
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
        //
    }
}
