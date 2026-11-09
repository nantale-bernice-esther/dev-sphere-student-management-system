@extends('layouts.app')

@section('title', 'New Registration')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">New Registration</h1>
        <p class="text-slate-500 mt-1">Enroll an existing student into an approved course module.</p>
    </div>
    <a href="{{ route('registrations.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>Back to registrations
    </a>
</div>

<div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
    <div class="flex items-center gap-2 font-medium">
        <i data-lucide="info" class="w-4 h-4 text-blue-600"></i>
        <span>Enrollment Policy:</span>
    </div>
    <p class="text-xs text-blue-700 mt-1">
        This form links a pre-existing student to an active course. A student cannot be registered more than once for the same course in the same semester.
    </p>
</div>

<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm max-w-3xl">
    <form action="{{ route('registrations.store') }}" method="POST" novalidate>
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Student Selection -->
            <div>
                <label for="student_id" class="block text-sm font-medium mb-1 text-slate-700">Select Student <span class="text-red-500">*</span></label>
                <select id="student_id" name="student_id" class="input-field @error('student_id') is-invalid border-red-500 @enderror">
                    <option value="">Select Student...</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->student_number }} — {{ $student->user->name ?? 'Student' }}
                        </option>
                    @endforeach
                </select>
                @error('student_id')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Course Selection -->
            <div>
                <label for="course_id" class="block text-sm font-medium mb-1 text-slate-700">Select Course <span class="text-red-500">*</span></label>
                <select id="course_id" name="course_id" class="input-field @error('course_id') is-invalid border-red-500 @enderror">
                    <option value="">Select Course...</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->code }} — {{ $course->title }} ({{ $course->credit_units }} CU)
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Semester Selection -->
            <div>
                <label for="semester" class="block text-sm font-medium mb-1 text-slate-700">Academic Semester <span class="text-red-500">*</span></label>
                <select id="semester" name="semester" class="input-field @error('semester') is-invalid border-red-500 @enderror">
                    <option value="">Select Semester...</option>
                    <option value="Semester I 2026/27" {{ old('semester', 'Semester I 2026/27') == 'Semester I 2026/27' ? 'selected' : '' }}>Semester I 2026/27</option>
                    <option value="Semester II 2026/27" {{ old('semester') == 'Semester II 2026/27' ? 'selected' : '' }}>Semester II 2026/27</option>
                </select>
                @error('semester')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="px-5 py-2.5 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
                Complete Registration
            </button>
            <a href="{{ route('registrations.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-600 border border-slate-200 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
