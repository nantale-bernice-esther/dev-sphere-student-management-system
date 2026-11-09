@extends('layouts.app')

@section('title', 'Roles & Permissions')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Roles &amp; Permissions</h1>
    <p class="text-slate-500 mt-1">Control which capabilities each role grants its members.</p>
</div>

<div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 flex items-start gap-3">
    <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600 shrink-0 mt-0.5"></i>
    <div>
        <p class="text-sm font-medium text-amber-800">Be careful when changing the Administrator role's permissions.</p>
        <p class="text-xs text-amber-700 mt-1">Removing permissions such as "manage roles" or "manage users" can lock you and other administrators out of this page.</p>
    </div>
</div>

<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
    <form action="{{ route('roles.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="py-3 px-4 text-sm font-semibold text-slate-500">Permission</th>
                        @foreach ($roles as $role)
                            <th class="py-3 px-4 text-sm font-semibold text-slate-500 text-center">{{ Str::headline($role->name) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($permissions as $permission)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 text-sm font-medium text-slate-900">{{ $permission->name }}</td>
                            @foreach ($roles as $role)
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox"
                                           name="permissions[{{ $role->name }}][]"
                                           value="{{ $permission->name }}"
                                           @checked($role->permissions->contains('id', $permission->id))
                                           class="w-4 h-4 text-[#2563eb] border-slate-300 rounded focus:ring-[#2563eb]">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-[#2563eb] rounded-lg text-sm font-medium text-white hover:bg-[#1d4ed8] shadow-sm transition-colors">
                Save permissions
            </button>
        </div>
    </form>
</div>
@endsection
