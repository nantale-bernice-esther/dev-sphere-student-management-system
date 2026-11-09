@extends('layouts.app')

@section('title', 'Add Course')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Add Course</h1>
        <p class="text-slate-500 mt-1">Create a new academic course module and assign an instructor.</p>
    </div>
    <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>Back to courses
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm max-w-3xl">
    <form action="{{ route('courses.store') }}" method="POST" novalidate>
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Course Code -->
            <div>
                <label for="code" class="block text-sm font-medium mb-1 text-slate-700">Course Code <span class="text-red-500">*</span></label>
                <input id="code" name="code" type="text"
                       value="{{ old('code') }}"
                       placeholder="e.g. BUC3131"
                       class="input-field @error('code') is-invalid border-red-500 @enderror">
                @error('code')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Course Title -->
            <div>
                <label for="title" class="block text-sm font-medium mb-1 text-slate-700">Course Title <span class="text-red-500">*</span></label>
                <input id="title" name="title" type="text"
                       value="{{ old('title') }}"
                       placeholder="e.g. Advanced Web Application Development"
                       class="input-field @error('title') is-invalid border-red-500 @enderror">
                @error('title')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Credit Units -->
            <div>
                <label for="credit_units" class="block text-sm font-medium mb-1 text-slate-700">Credit Units <span class="text-red-500">*</span></label>
                <input id="credit_units" name="credit_units" type="number" min="1" max="10"
                       value="{{ old('credit_units', 4) }}"
                       placeholder="e.g. 4"
                       class="input-field @error('credit_units') is-invalid border-red-500 @enderror">
                @error('credit_units')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lecturer Assignment -->
            <div>
                <label for="lecturer_id" class="block text-sm font-medium mb-1 text-slate-700">Assigned Lecturer</label>
                <select id="lecturer_id" name="lecturer_id" class="input-field @error('lecturer_id') is-invalid border-red-500 @enderror">
                    <option value="">Select Lecturer (Optional)...</option>
                    @foreach($lecturers as $lecturer)
                        <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                            {{ $lecturer->name }} ({{ $lecturer->email }})
                        </option>
                    @endforeach
                </select>
                @error('lecturer_id')
                    <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="px-5 py-2.5 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
                Save Course
            </button>
            <a href="{{ route('courses.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-600 border border-slate-200 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
