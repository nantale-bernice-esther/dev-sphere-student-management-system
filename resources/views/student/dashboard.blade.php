@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Student Dashboard</h1>
    <p class="text-slate-500 mt-1">Welcome back, {{ auth()->user()->name }}. Review your registered courses and enrollment status.</p>
</div>

<!-- Stats Card -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
    @php
        $student = auth()->user()->student;
        $myRegistrations = $student ? $student->registrations()->with('course')->get() : collect();
        $totalCredits = $myRegistrations->sum(fn($r) => $r->course->credit_units ?? 0);
    @endphp
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center border border-blue-100">
                <i data-lucide="book-open" class="w-6 h-6 text-[#2563eb]"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $myRegistrations->count() }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Registered Courses</p>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center border border-emerald-100">
                <i data-lucide="award" class="w-6 h-6 text-emerald-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $totalCredits }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Credit Units</p>
            </div>
        </div>
    </div>
</div>

<!-- Registered Courses Table -->
<div class="mb-4 flex items-center justify-between">
    <h2 class="text-lg font-bold text-slate-900">Current Semester Registrations</h2>
    <a href="{{ route('student.courses') }}" class="inline-flex items-center px-3 py-1.5 bg-[#2563eb] rounded-lg text-xs font-semibold text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
        <i data-lucide="plus" class="w-3.5 h-3.5 mr-1"></i> Register New Course
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
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Lecturer</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Semester</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($myRegistrations as $reg)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $reg->course->code ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-800">{{ $reg->course->title ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $reg->course->credit_units ?? '-' }} CU</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $reg->course->lecturer->name ?? 'Staff' }}</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700">
                                {{ $reg->semester }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-sm text-slate-500">
                            You have not registered for any courses this semester.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
