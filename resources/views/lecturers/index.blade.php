@extends('layouts.app')

@section('title', 'Lecturers')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Lecturers</h1>
        <p class="text-slate-500 mt-1">Manage lecturer accounts and course assignments.</p>
    </div>
    @if(auth()->user()->can('manage lecturers') || auth()->user()->hasRole('administrator'))
        <a href="{{ route('lecturers.create') }}" class="inline-flex items-center px-4 py-2 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Add lecturer
        </a>
    @endif
</div>

<!-- Search / Filter -->
<div class="mb-4 max-w-sm">
    <form method="GET" action="{{ route('lecturers.index') }}">
        <div class="relative">
            <input type="search" name="search" value="{{ request('search') }}" class="input-field pl-9" placeholder="Search by name or email...">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
        </div>
    </form>
</div>

<!-- Lecturers Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Name</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Email</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Courses Assigned</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($lecturers as $lecturer)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $lecturer->name }}</td>
                        <td class="py-3 px-4 text-sm text-slate-500">{{ $lecturer->email }}</td>
                        <td class="py-3 px-4 text-sm text-slate-700">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $lecturer->courses_count }} {{ Str::plural('course', $lecturer->courses_count) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <div class="inline-flex items-center gap-3">
                                @if(auth()->user()->can('manage lecturers') || auth()->user()->hasRole('administrator'))
                                    <a href="{{ route('lecturers.edit', $lecturer) }}" class="text-[#2563eb] hover:text-[#1d4ed8] transition-colors" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>

                                    @if($lecturer->id !== auth()->id())
                                        <form action="{{ route('lecturers.destroy', $lecturer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lecturer?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 px-4 text-center text-sm text-slate-500">
                            No lecturers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($lecturers->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $lecturers->links() }}
        </div>
    @endif
</div>
@endsection
