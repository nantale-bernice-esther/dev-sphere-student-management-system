@extends('layouts.app')

@section('title', 'Course Students')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">{{ $course->code }} — Enrolled Students</h1>
        <p class="text-slate-500 mt-1">{{ $course->title }} ({{ $course->credit_units }} Credit Units)</p>
    </div>
    <a href="{{ route('lecturer.courses') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>Back to my courses
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Student No.</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Name</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Email</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Programme</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Registered On</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($students as $student)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $student->student_number }}</td>
                        <td class="py-3 px-4 text-sm text-slate-800">{{ $student->user->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-500">{{ $student->user->email ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-700">{{ $student->programme }}</td>
                        <td class="py-3 px-4 text-sm text-slate-500">
                            {{ $student->pivot->created_at ? \Carbon\Carbon::parse($student->pivot->created_at)->format('d M Y') : 'N/A' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-sm text-slate-500">
                            No students are registered for this course yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($students, 'hasPages') && $students->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $students->links() }}
        </div>
    @endif
</div>
@endsection
