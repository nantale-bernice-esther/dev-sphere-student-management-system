@extends('layouts.app')

@section('title', 'Course Details')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Course Details</h1>
        <p class="text-slate-500 mt-1">Course module specification and enrolled student roster.</p>
    </div>
    <div class="flex items-center gap-2">
        @if(auth()->user()->can('manage courses') || auth()->user()->hasRole('administrator'))
            <a href="{{ route('courses.edit', $course) }}" class="inline-flex items-center px-4 py-2 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
                <i data-lucide="pencil" class="w-4 h-4 mr-2"></i>Edit course
            </a>
        @endif
        <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>Back to courses
        </a>
    </div>
</div>

<!-- Course Details Card -->
<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm mb-8">
    <dl class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div>
            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Course Code</dt>
            <dd class="text-sm font-medium text-slate-900 mt-1">{{ $course->code }}</dd>
        </div>
        <div>
            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Course Title</dt>
            <dd class="text-sm font-medium text-slate-900 mt-1">{{ $course->title }}</dd>
        </div>
        <div>
            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Credit Units</dt>
            <dd class="text-sm font-medium text-slate-900 mt-1">{{ $course->credit_units }} CU</dd>
        </div>
        <div>
            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Assigned Lecturer</dt>
            <dd class="text-sm font-medium text-slate-900 mt-1">{{ $course->lecturer->name ?? 'Unassigned' }}</dd>
        </div>
    </dl>
</div>

<!-- Registered Students Section -->
<div class="mb-4 flex justify-between items-center">
    <div>
        <h2 class="text-lg font-bold text-slate-900">Enrolled Students</h2>
        <p class="text-xs text-slate-500">Students officially registered for this module.</p>
    </div>
    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
        {{ $course->students->count() }} enrolled
    </span>
</div>

<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Student No.</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Name</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Email</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Programme</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Semester</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($course->students as $student)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $student->student_number }}</td>
                        <td class="py-3 px-4 text-sm text-slate-800">{{ $student->user->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-500">{{ $student->user->email ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-700">{{ $student->programme }}</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $student->pivot->semester ?? 'N/A' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-sm text-slate-500">
                            No students have registered for this course yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
