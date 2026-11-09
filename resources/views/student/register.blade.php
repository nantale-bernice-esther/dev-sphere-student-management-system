@extends('layouts.app')

@section('title', 'Register Course')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Course Registration</h1>
        <p class="text-slate-500 mt-1">Select an approved course and confirm your enrollment for this semester.</p>
    </div>
    <a href="{{ route('student.courses') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>Back to available courses
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm max-w-2xl">
    <form action="{{ route('student.register.store') }}" method="POST" novalidate>
        @csrf

        <div class="space-y-5">
            <!-- Course Selection -->
            <div>
                <label for="course_id" class="block text-sm font-medium mb-1 text-slate-700">Select Course <span class="text-red-500">*</span></label>
                <select id="course_id" name="course_id" class="input-field @error('course_id') is-invalid border-red-500 @enderror">
                    <option value="">Select Course...</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ (old('course_id', request('course_id')) == $course->id) ? 'selected' : '' }}>
                            {{ $course->code }} — {{ $course->title }} ({{ $course->credit_units }} CU) - {{ $course->lecturer->name ?? 'Staff' }}
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

            <!-- Student Confirmation Notice -->
            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 text-xs text-slate-600 space-y-1">
                <p class="font-semibold text-slate-800">Registration Instructions:</p>
                <p>&bull; Enrolling will officially add this course to your academic transcript for the selected semester.</p>
                <p>&bull; Duplicate registrations for the same semester are automatically blocked by the system.</p>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="px-5 py-2.5 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
                Confirm Registration
            </button>
            <a href="{{ route('student.courses') }}" class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-600 border border-slate-200 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
