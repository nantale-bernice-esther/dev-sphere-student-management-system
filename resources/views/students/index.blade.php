@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Students</h1>
        <p class="text-slate-500 mt-1">Create, edit and manage student records.</p>
    </div>
    @if(auth()->user()->can('manage student') || auth()->user()->hasRole('administrator'))
        <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Add student
        </a>
    @endif
</div>

<!-- Search / Filter -->
<div class="mb-4 max-w-sm">
    <form method="GET" action="{{ route('students.index') }}">
        <div class="relative">
            <input type="search" name="search" value="{{ request('search') }}" class="input-field pl-9" placeholder="Search by name, student no, or programme...">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
        </div>
    </form>
</div>

<!-- Students Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Student No.</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Name</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Email</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Programme</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Year</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($students as $student)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $student->student_number }}</td>
                        <td class="py-3 px-4 text-sm text-slate-900">{{ $student->user->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-500">{{ $student->user->email ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-700">{{ $student->programme }}</td>
                        <td class="py-3 px-4 text-sm text-slate-700">Year {{ $student->year_of_study }}</td>
                        <td class="py-3 px-4 text-sm">
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('students.show', $student) }}" class="text-slate-500 hover:text-slate-800 transition-colors" title="View details">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                @if(auth()->user()->can('manage student') || auth()->user()->hasRole('administrator'))
                                    <a href="{{ route('students.edit', $student) }}" class="text-[#2563eb] hover:text-[#1d4ed8] transition-colors" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>

                                    <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" class="inline">
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
                            No students found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $students->links() }}
        </div>
    @endif
</div>
@endsection
