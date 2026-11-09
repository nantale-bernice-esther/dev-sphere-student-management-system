@extends('layouts.app')

@section('title', 'Courses')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Courses</h1>
        <p class="text-slate-500 mt-1">Manage academic course modules, credit units and lecturer allocations.</p>
    </div>
    @if(auth()->user()->can('manage courses') || auth()->user()->hasRole('administrator'))
        <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Add course
        </a>
    @endif
</div>

<!-- Search / Filter -->
<div class="mb-4 max-w-sm">
    <form method="GET" action="{{ route('courses.index') }}">
        <div class="relative">
            <input type="search" name="search" value="{{ request('search') }}" class="input-field pl-9" placeholder="Search by course code or title...">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
        </div>
    </form>
</div>

<!-- Courses Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Course Code</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Title</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Credit Units</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Lecturer</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Enrolled</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($courses as $course)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $course->code }}</td>
                        <td class="py-3 px-4 text-sm text-slate-900">{{ $course->title }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $course->credit_units }} CU</td>
                        <td class="py-3 px-4 text-sm text-slate-700">
                            {{ $course->lecturer->name ?? 'Unassigned' }}
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                {{ $course->students_count ?? $course->students->count() }} students
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('courses.show', $course) }}" class="text-slate-500 hover:text-slate-800 transition-colors" title="View details">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                @if(auth()->user()->can('manage courses') || auth()->user()->hasRole('administrator'))
                                    <a href="{{ route('courses.edit', $course) }}" class="text-[#2563eb] hover:text-[#1d4ed8] transition-colors" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>

                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 px-4 text-center text-sm text-slate-500">
                            No courses found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($courses->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection
