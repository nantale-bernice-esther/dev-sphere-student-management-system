{{-- resources/views/partials/alerts.blade.php --}}
@if (session('success'))
    <div class="mb-4 flex items-start gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm" role="alert">
        <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0 text-emerald-600 mt-0.5"></i>
        <div class="flex-1 font-medium">{{ session('success') }}</div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900" aria-label="Close">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="mb-4 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 shadow-sm" role="alert">
        <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 text-red-600 mt-0.5"></i>
        <div class="flex-1 font-medium">{{ session('error') }}</div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-900" aria-label="Close">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800 shadow-sm" role="alert">
        <div class="flex items-center gap-2 font-semibold mb-2 text-red-900">
            <i data-lucide="alert-octagon" class="w-5 h-5 text-red-600 shrink-0"></i>
            <span>Please resolve the following errors:</span>
        </div>
        <ul class="list-disc list-inside space-y-1 text-xs text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
