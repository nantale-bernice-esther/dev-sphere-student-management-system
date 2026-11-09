@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Edit Student</h1>
        <p class="text-slate-500 mt-1">Update student profile and academic details.</p>
    </div>
    <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>Back to students
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm max-w-3xl">
    <form action="{{ route('students.update', $student) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Student Number -->
            <div>
                <label for="student_number" class="block text-sm font-medium mb-1 text-slate-700">Student Number <span class="text-red-500">*</span></label>
                <input id="student_number" name="student_number" type="text"
                       value="{{ old('student_number', $student->student_number) }}"
                       class="input-field @error('student_number') is-invalid border-red-500 @enderror">
                @error('student_number')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium mb-1 text-slate-700">Full Name <span class="text-red-500">*</span></label>
                <input id="name" name="name" type="text"
                       value="{{ old('name', $student->user->name ?? '') }}"
                       class="input-field @error('name') is-invalid border-red-500 @enderror">
                @error('name')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium mb-1 text-slate-700">Email Address <span class="text-red-500">*</span></label>
                <input id="email" name="email" type="email"
                       value="{{ old('email', $student->user->email ?? '') }}"
                       class="input-field @error('email') is-invalid border-red-500 @enderror">
                @error('email')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Programme -->
            <div>
                <label for="programme" class="block text-sm font-medium mb-1 text-slate-700">Programme <span class="text-red-500">*</span></label>
                <select id="programme" name="programme" class="input-field @error('programme') is-invalid border-red-500 @enderror">
                    <option value="">Select Programme...</option>
                    @foreach(['Business Computing', 'Information Systems', 'Computer Science', 'Business Administration'] as $prog)
                        <option value="{{ $prog }}" {{ old('programme', $student->programme) == $prog ? 'selected' : '' }}>
                            {{ $prog }}
                        </option>
                    @endforeach
                </select>
                @error('programme')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Year of Study -->
            <div>
                <label for="year_of_study" class="block text-sm font-medium mb-1 text-slate-700">Year of Study <span class="text-red-500">*</span></label>
                <select id="year_of_study" name="year_of_study" class="input-field @error('year_of_study') is-invalid border-red-500 @enderror">
                    <option value="">Select Year...</option>
                    @for($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ old('year_of_study', $student->year_of_study) == $i ? 'selected' : '' }}>
                            Year {{ $i }}
                        </option>
                    @endfor
                </select>
                @error('year_of_study')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="px-5 py-2.5 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
                Update Student
            </button>
            <a href="{{ route('students.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-600 border border-slate-200 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
