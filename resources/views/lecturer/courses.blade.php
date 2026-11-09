@extends('layouts.app')

@section('title', 'My Assigned Courses')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">My Courses</h1>
        <p class="text-slate-500 mt-1">Modules assigned to you for instruction and grading.</p>
    </div>
</div>

<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Course Code</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Title</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Credit Units</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Enrolled Students</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Roster</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($courses as $course)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $course->code }}</td>
                        <td class="py-3 px-4 text-sm text-slate-800">{{ $course->title }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $course->credit_units }} CU</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $course->students_count ?? $course->students->count() }} students
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <a href="{{ route('lecturer.course.students', $course) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#2563eb] hover:text-[#1d4ed8] hover:underline">
                                <i data-lucide="users" class="w-4 h-4"></i>
                                View Students
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

    @if(method_exists($courses, 'hasPages') && $courses->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection
