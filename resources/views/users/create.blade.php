<x-layouts.app>
    <div class="mb-6">
        <flux:heading size="xl">{{ __('Create User') }}</flux:heading>
    </div>

    <form method="POST" action="{{ route('users.store') }}" class="max-w-2xl space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:input name="first_name" label="First Name" required />
            <flux:input name="middle_name" label="Middle Name" />
            <flux:input name="last_name" label="Last Name" />
            <flux:input name="name" label="Full Name" required description="Display name" />
            
            <flux:input name="email" label="Email" type="email" required />
            <flux:input name="username" label="Username" />
            
            <flux:input name="phone_number" label="Phone Number" />
            
            <div class="space-y-3">
                <label class="block text-sm font-medium text-zinc-800 dark:text-white" for="role">Role</label>
                <select name="role" id="role" required class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-zinc-400 focus:ring-2 focus:ring-zinc-400/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:focus:border-zinc-500">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="supplier">Supplier</option>
                    <option value="customer">Customer</option>
                </select>
            </div>
            
            <div class="space-y-3">
                <label class="block text-sm font-medium text-zinc-800 dark:text-white" for="status">Status</label>
                <select name="status" id="status" required class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-zinc-400 focus:ring-2 focus:ring-zinc-400/10 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:focus:border-zinc-500">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            
            <flux:input name="account_type" label="Account Type" />
            
            <flux:input name="password" label="Password" type="password" required />
            <flux:input name="password_confirmation" label="Confirm Password" type="password" required />
        </div>

        <div class="flex justify-end gap-2">
            <flux:button variant="ghost" :href="route('users.index')" wire:navigate>{{ __('Cancel') }}</flux:button>
            <flux:button type="submit" variant="primary">{{ __('Create User') }}</flux:button>
        </div>
    </form>
</x-layouts.app>
