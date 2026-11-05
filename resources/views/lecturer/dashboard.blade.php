@extends('layouts.app')

@section('title', 'Lecturer Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Lecturer Dashboard</h1>
    <p class="text-slate-500 mt-1">Welcome back, {{ auth()->user()->name }}. Here is an overview of your allocated teaching courses.</p>
</div>

<!-- Stats Card -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
    @php
        $myCourses = \App\Models\Course::where('lecturer_id', auth()->id())->withCount('students')->get();
        $totalStudents = $myCourses->sum('students_count');
    @endphp
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center border border-blue-100">
                <i data-lucide="book-open" class="w-6 h-6 text-[#2563eb]"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $myCourses->count() }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Assigned Courses</p>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center border border-emerald-100">
                <i data-lucide="users" class="w-6 h-6 text-emerald-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $totalStudents }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Students Enrolled</p>
            </div>
        </div>
    </div>
</div>

<!-- Assigned Courses Table -->
<div class="mb-4 flex items-center justify-between">
    <h2 class="text-lg font-bold text-slate-900">My Teaching Modules</h2>
    <a href="{{ route('lecturer.courses') }}" class="text-xs font-semibold text-[#2563eb] hover:underline">
        Manage all courses &rarr;
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Course Code</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Title</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Credits</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Students</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($myCourses as $course)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $course->code }}</td>
                        <td class="py-3 px-4 text-sm text-slate-800">{{ $course->title }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $course->credit_units }} CU</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-50 text-blue-700">
                                {{ $course->students_count }} enrolled
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <a href="{{ route('lecturer.course.students', $course) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#2563eb] hover:underline">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i> View Roster
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-sm text-slate-500">
                            You have no courses currently assigned.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
