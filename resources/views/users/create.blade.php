<x-layouts.app>
    <div class="max-w-5xl mx-auto py-6">
        <!-- Header & Navigation -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('users.index') }}" wire:navigate class="p-2 -ml-2 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <flux:icon icon="arrow-left" class="size-5" />
                </a>
                <div>
                    <flux:heading size="xl" class="leading-tight">{{ __('Create User') }}</flux:heading>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Add a new user to the system.</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('users.store') }}" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Access Control -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- New User Placeholder -->
                     <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-24 h-24 mb-4 rounded-full bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center text-zinc-300 dark:text-zinc-600 border border-zinc-100 dark:border-zinc-700 border-dashed border-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                            </div>
                            <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">New Account</h3>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Fill in the details to create a new user profile.</p>
                        </div>
                    </div>

                    <!-- Role & Status Card -->
                    <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm space-y-4">
                        <flux:heading size="sm" class="mb-2 border-b border-zinc-100 dark:border-zinc-800 pb-2">Access Control</flux:heading>
                        
                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" for="role">Role</label>
                            <select name="role" id="role" required class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" for="status">Status</label>
                            <select name="status" id="status" required class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="pt-2">
                            <flux:input name="account_type" label="Account Type" :value="old('account_type')" />
                        </div>
                    </div>
                </div>

                <!-- Right Column: Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Info Section -->
                    <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Personal Information</h2>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Basic personal details and identification.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <flux:input name="first_name" label="First Name" :value="old('first_name')" required />
                            <flux:input name="middle_name" label="Middle Name" :value="old('middle_name')" />
                            <flux:input name="last_name" label="Last Name" :value="old('last_name')" />
                            <flux:input name="name" label="Display Name" required description="Name displayed on public profile" :value="old('name')" />
                            
                            <div class="md:col-span-2">
                                <flux:input name="phone_number" label="Phone Number" :value="old('phone_number')" />
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Credentials Section -->
                    <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Account Credentials</h2>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Email and username for signing in.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <flux:input name="email" label="Email Address" type="email" required :value="old('email')" />
                            <flux:input name="username" label="Username" :value="old('username')" />
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Security</h2>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Set a strong password for the account.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <flux:input name="password" label="Password" type="password" required />
                            <flux:input name="password_confirmation" label="Confirm Password" type="password" required />
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4">
                        <flux:button variant="ghost" :href="route('users.index')" wire:navigate class="!bg-transparent hover:!bg-zinc-100 dark:hover:!bg-zinc-800">{{ __('Cancel') }}</flux:button>
                        <flux:button type="submit" variant="primary" class="min-w-[120px]">{{ __('Create User') }}</flux:button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
