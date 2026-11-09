@extends('layouts.app')

@section('title', 'Edit Lecturer')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Edit Lecturer</h1>
        <p class="text-slate-500 mt-1">Update the account details for {{ $lecturer->name }}.</p>
    </div>
    <a href="{{ route('lecturers.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>Back to lecturers
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm max-w-3xl">
    <form action="{{ route('lecturers.update', $lecturer) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        @include('lecturers._form')

        <div class="mt-6 flex items-center gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="px-5 py-2.5 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
                Update Lecturer
            </button>
            <a href="{{ route('lecturers.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-600 border border-slate-200 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
