@extends('layouts.app')

@section('title', 'My Registrations')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">My Registrations</h1>
        <p class="text-slate-500 mt-1">Official list of courses you are enrolled in for the current academic year.</p>
    </div>
    <a href="{{ route('student.register') }}" class="inline-flex items-center px-4 py-2 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Register for another course
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Course Code</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Title</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Credit Units</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Lecturer</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Semester</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($registrations as $reg)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $reg->course->code ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-800">{{ $reg->course->title ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $reg->course->credit_units ?? '-' }} CU</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $reg->course->lecturer->name ?? 'Staff' }}</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $reg->semester }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Enrolled
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 px-4 text-center text-sm text-slate-500">
                            You have not registered for any courses yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
