<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LecturerController extends Controller
{
    /**
     * Display a listing of lecturers.
     */
    public function index(Request $request)
    {
        $query = User::role('lecturer')->withCount('courses');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $lecturers = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('lecturers.index', compact('lecturers'));
    }

    /**
     * Show the form for creating a new lecturer.
     */
    public function create()
    {
        return view('lecturers.create');
    }

    /**
     * Store a newly created lecturer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $lecturer = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $lecturer->assignRole('lecturer');

        return redirect()->route('lecturers.index')->with('success', 'Lecturer created successfully.');
    }

    /**
     * Show the form for editing the specified lecturer.
     */
    public function edit(User $lecturer)
    {
        return view('lecturers.edit', compact('lecturer'));
    }

    /**
     * Update the specified lecturer in storage.
     */
    public function update(Request $request, User $lecturer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($lecturer->id),
            ],
            'password' => 'nullable|string|min:8',
        ]);

        $lecturer->name = $validated['name'];
        $lecturer->email = $validated['email'];

        if (! empty($validated['password'])) {
            $lecturer->password = Hash::make($validated['password']);
        }

        $lecturer->save();

        return redirect()->route('lecturers.index')->with('success', 'Lecturer updated successfully.');
    }

    /**
     * Remove the specified lecturer from storage.
     */
    public function destroy(User $lecturer)
    {
        if ($lecturer->id === auth()->id()) {
            return redirect()->route('lecturers.index')->with('error', 'You cannot delete your own account.');
        }

        $lecturer->delete();

        return redirect()->route('lecturers.index')->with('success', 'Lecturer deleted successfully.');
    }
}
