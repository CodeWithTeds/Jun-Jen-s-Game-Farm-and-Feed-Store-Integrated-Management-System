<x-layouts.app>
    <div class="mb-6">
        <flux:heading size="xl">{{ __('Edit User') }}</flux:heading>
    </div>

    <form method="POST" action="{{ route('users.update', $user->id) }}" class="max-w-2xl space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:input name="first_name" label="First Name" :value="old('first_name', $user->first_name)" />
            <flux:input name="middle_name" label="Middle Name" :value="old('middle_name', $user->middle_name)" />
            <flux:input name="last_name" label="Last Name" :value="old('last_name', $user->last_name)" />
            <flux:input name="name" label="Full Name" required description="Display name" :value="old('name', $user->name)" />
            
            <flux:input name="email" label="Email" type="email" required :value="old('email', $user->email)" />
            <flux:input name="username" label="Username" :value="old('username', $user->username)" />
            
            <flux:input name="phone_number" label="Phone Number" :value="old('phone_number', $user->phone_number)" />
            
            <div class="space-y-3">
                <label class="block text-sm font-medium text-zinc-800 dark:text-white" for="role">Role</label>
                <select name="role" id="role" required class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-zinc-400 focus:ring-2 focus:ring-zinc-400/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:focus:border-zinc-500">
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="supplier" {{ old('role', $user->role) == 'supplier' ? 'selected' : '' }}>Supplier</option>
                    <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
            </div>
            
            <div class="space-y-3">
                <label class="block text-sm font-medium text-zinc-800 dark:text-white" for="status">Status</label>
                <select name="status" id="status" required class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-zinc-400 focus:ring-2 focus:ring-zinc-400/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:focus:border-zinc-500">
                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <flux:input name="account_type" label="Account Type" :value="old('account_type', $user->account_type)" />
            
            <div class="col-span-2">
                <flux:heading size="sm" class="mb-2">Change Password (optional)</flux:heading>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input name="password" label="New Password" type="password" />
                    <flux:input name="password_confirmation" label="Confirm New Password" type="password" />
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <flux:button variant="ghost" :href="route('users.index')" wire:navigate>{{ __('Cancel') }}</flux:button>
            <flux:button type="submit" variant="primary">{{ __('Update User') }}</flux:button>
        </div>
    </form>
</x-layouts.app>
