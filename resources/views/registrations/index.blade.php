@extends('layouts.app')

@section('title', 'Registrations')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Registrations</h1>
        <p class="text-slate-500 mt-1">Audit which students are officially enrolled into academic course modules.</p>
    </div>
    @if(auth()->user()->can('manage registrations') || auth()->user()->hasRole('administrator'))
        <a href="{{ route('registrations.create') }}" class="inline-flex items-center px-4 py-2 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>New registration
        </a>
    @endif
</div>

<!-- Search / Filter -->
<div class="mb-4 max-w-sm">
    <form method="GET" action="{{ route('registrations.index') }}">
        <div class="relative">
            <input type="search" name="search" value="{{ request('search') }}" class="input-field pl-9" placeholder="Search student or course...">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
        </div>
    </form>
</div>

<!-- Registrations Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Student No.</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Student Name</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Course</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Semester</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Registered On</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($registrations as $registration)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">
                            {{ $registration->student->student_number ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-800">
                            {{ $registration->student->user->name ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-800">
                            <span class="font-medium text-slate-900">{{ $registration->course->code ?? 'N/A' }}</span>
                            <span class="text-slate-500">— {{ $registration->course->title ?? 'N/A' }}</span>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $registration->semester }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-500">
                            {{ $registration->created_at->format('d M Y') }}
                        </td>
                        <td class="py-3 px-4 text-sm">
                            @if(auth()->user()->can('manage registrations') || auth()->user()->hasRole('administrator'))
                                <form action="{{ route('registrations.destroy', $registration) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this registration?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 hover:underline transition-colors">
                                        Remove
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400">View only</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 px-4 text-center text-sm text-slate-500">
                            No course registrations found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($registrations->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $registrations->links() }}
        </div>
    @endif
</div>
@endsection
