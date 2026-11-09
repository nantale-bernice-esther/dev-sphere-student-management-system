@extends('layouts.app')

@section('title', 'Available Courses')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Available Courses</h1>
        <p class="text-slate-500 mt-1">Browse approved academic course units and enroll for the current term.</p>
    </div>
    <a href="{{ route('student.registrations') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
        <i data-lucide="award" class="w-4 h-4 mr-2"></i>My Registrations
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse ($courses as $course)
        @php
            $isEnrolled = isset($registeredCourseIds) && $registeredCourseIds->contains($course->id);
        @endphp
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold px-2.5 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200 uppercase tracking-wider">
                        {{ $course->code }}
                    </span>
                    <span class="text-xs font-semibold text-slate-500">
                        {{ $course->credit_units }} Credit Units
                    </span>
                </div>
                <h3 class="font-bold text-slate-900 text-base leading-snug mb-1">
                    {{ $course->title }}
                </h3>
                <p class="text-xs text-slate-500 flex items-center gap-1.5 mt-2">
                    <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                    <span>{{ $course->lecturer->name ?? 'Lecturer Unassigned' }}</span>
                </p>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                @if ($isEnrolled)
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i> Already Enrolled
                    </span>
                @else
                    <a href="{{ route('student.register', ['course_id' => $course->id]) }}" class="inline-flex items-center px-4 py-2 bg-[#2563eb] rounded-lg text-xs font-semibold text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
                        <i data-lucide="plus-circle" class="w-3.5 h-3.5 mr-1.5"></i> Register Course
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center text-slate-500 bg-white rounded-xl border border-slate-200">
            No courses are currently available for registration.
        </div>
    @endforelse
</div>
@endsection
