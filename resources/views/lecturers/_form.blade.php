<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <!-- Full Name -->
    <div>
        <label for="name" class="block text-sm font-medium mb-1 text-slate-700">Full Name <span class="text-red-500">*</span></label>
        <input id="name" name="name" type="text"
               value="{{ old('name', $lecturer->name ?? '') }}"
               placeholder="e.g. John Doe"
               class="input-field @error('name') is-invalid border-red-500 @enderror">
        @error('name')
            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium mb-1 text-slate-700">Email Address <span class="text-red-500">*</span></label>
        <input id="email" name="email" type="email"
               value="{{ old('email', $lecturer->email ?? '') }}"
               placeholder="e.g. john.doe@mubs.ac.ug"
               class="input-field @error('email') is-invalid border-red-500 @enderror">
        @error('email')
            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-sm font-medium mb-1 text-slate-700">Password <span class="text-red-500">*</span></label>
        <input id="password" name="password" type="password"
               placeholder="{{ isset($lecturer) ? 'Leave blank to keep the current password' : '' }}"
               class="input-field @error('password') is-invalid border-red-500 @enderror">
        @error('password')
            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
        @enderror
    </div>
</div>
