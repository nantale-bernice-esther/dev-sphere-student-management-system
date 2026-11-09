@extends('layouts.app')

@section('title', 'User Access')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">User Access</h1>
        <p class="text-slate-500 mt-1">Assign system accounts to the administrator, lecturer or student role.</p>
    </div>
</div>

<!-- Search / Filter -->
<div class="mb-4 max-w-sm">
    <form method="GET" action="{{ route('users.index') }}">
        <div class="relative">
            <input type="search" name="search" value="{{ request('search') }}" class="input-field pl-9" placeholder="Search by name or email...">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3.5"></i>
        </div>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Name</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Email</th>
                    <th class="py-3 px-4 text-sm font-semibold text-slate-500">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-sm font-medium text-slate-900">
                            {{ $user->name }}
                            @if($user->id === auth()->id())
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">you</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-500">{{ $user->email }}</td>
                        <td class="py-3 px-4 text-sm">
                            @if($user->id === auth()->id())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $user->roles->pluck('name')->join(', ') ?: 'No role' }}
                                </span>
                            @else
                                <form action="{{ route('users.update', $user) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="input-field !w-auto !py-1.5 text-sm">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>{{ Str::headline($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-3 py-1.5 bg-[#2563eb] rounded-lg text-xs font-medium text-white hover:bg-[#1d4ed8] transition-colors">
                                        Save
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-8 px-4 text-center text-sm text-slate-500">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
