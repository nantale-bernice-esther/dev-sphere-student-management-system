@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Student Details</h1>
        <p class="text-slate-500 mt-1">Profile and enrollment information for {{ $student->user->name ?? 'Student' }}.</p>
    </div>
    <div class="flex items-center gap-2">
        @if(auth()->user()->can('manage student') || auth()->user()->hasRole('administrator'))
            <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center px-4 py-2 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
                <i data-lucide="pencil" class="w-4 h-4 mr-2"></i>Edit student
            </a>
        @endif
        <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>Back to students
        </a>
    </div>
</div>

<!-- Details Card -->
<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm mb-8">
    <dl class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <div>
            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Student Number</dt>
            <dd class="text-sm font-medium text-slate-900 mt-1">{{ $student->student_number }}</dd>
        </div>
        <div>
            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Full Name</dt>
            <dd class="text-sm font-medium text-slate-900 mt-1">{{ $student->user->name ?? 'N/A' }}</dd>
        </div>
        <div>
            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email Address</dt>
            <dd class="text-sm font-medium text-slate-900 mt-1">{{ $student->user->email ?? 'N/A' }}</dd>
        </div>
        <div>
            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Programme</dt>
            <dd class="text-sm font-medium text-slate-900 mt-1">{{ $student->programme }}</dd>
        </div>
        <div>
            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Year of Study</dt>
            <dd class="text-sm font-medium text-slate-900 mt-1">Year {{ $student->year_of_study }}</dd>
        </div>
        <div>
            <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Account Created</dt>
            <dd class="text-sm font-medium text-slate-900 mt-1">{{ $student->created_at->format('d M Y') }}</dd>
        </div>
    </dl>
</div>

<!-- Registered Courses Section -->
<div class="mb-4">
    <h2 class="text-lg font-bold text-slate-900">Registered Courses</h2>
    <p class="text-xs text-slate-500">Modules currently enrolled by this student.</p>
</div>

<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Code</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Title</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Credits</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Lecturer</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Registered on</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($student->courses as $course)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $course->code }}</td>
                        <td class="py-3 px-4 text-sm text-slate-800">{{ $course->title }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $course->credit_units }} CU</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $course->lecturer->name ?? 'Unassigned' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $course->pivot->created_at ? \Illuminate\Support\Carbon::parse($course->pivot->created_at)->format('d M Y') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-sm text-slate-500">
                            This student has not registered for any courses yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
