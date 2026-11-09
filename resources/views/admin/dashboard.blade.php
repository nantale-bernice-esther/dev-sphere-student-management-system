@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Administrator Dashboard</h1>
    <p class="text-slate-500 mt-1">Overview of academic records, enrollment statistics and system activity.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
    <!-- Students Count -->
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center border border-blue-100">
                <i data-lucide="users" class="w-6 h-6 text-[#2563eb]"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $studentsCount ?? \App\Models\Student::count() }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Students</p>
            </div>
        </div>
    </div>

    <!-- Courses Count -->
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center border border-amber-100">
                <i data-lucide="book-open" class="w-6 h-6 text-[#d97706]"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $coursesCount ?? \App\Models\Course::count() }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Courses</p>
            </div>
        </div>
    </div>

    <!-- Registrations Count -->
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center border border-emerald-100">
                <i data-lucide="clipboard-list" class="w-6 h-6 text-emerald-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $registrationsCount ?? \App\Models\Registration::count() }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Registrations</p>
            </div>
        </div>
    </div>

    <!-- Lecturers Count -->
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center border border-purple-100">
                <i data-lucide="graduation-cap" class="w-6 h-6 text-purple-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $lecturersCount ?? \App\Models\User::role('lecturer')->count() }}</p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Lecturers</p>
            </div>
        </div>
    </div>
</div>

<!-- Latest Registrations -->
<div class="mb-4 flex items-center justify-between">
    <h2 class="text-lg font-bold text-slate-900">Latest Registrations</h2>
    <a href="{{ route('registrations.index') }}" class="text-xs font-semibold text-[#2563eb] hover:underline">
        View all registrations &rarr;
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Student</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Course</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Semester</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Registered On</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @php
                    $recentRegs = $latestRegistrations ?? \App\Models\Registration::with(['student.user', 'course'])->latest()->take(5)->get();
                @endphp
                @forelse ($recentRegs as $reg)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">
                            {{ $reg->student->user->name ?? 'N/A' }}
                            <span class="text-xs text-slate-400 block font-normal">{{ $reg->student->student_number ?? '' }}</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-800">
                            <span class="font-semibold text-slate-900">{{ $reg->course->code ?? 'N/A' }}</span>
                            <span class="text-slate-500">— {{ $reg->course->title ?? 'N/A' }}</span>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700">
                                {{ $reg->semester }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-500">
                            {{ $reg->created_at->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 px-4 text-center text-sm text-slate-500">
                            No recent registrations recorded.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
