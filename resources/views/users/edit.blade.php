<x-layouts.app>
    <div class="max-w-5xl mx-auto py-6">
        <!-- Header & Navigation -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('users.index') }}" wire:navigate class="p-2 -ml-2 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <flux:icon icon="arrow-left" class="size-5" />
                </a>
                <div>
                    <flux:heading size="xl" class="leading-tight">{{ __('Edit User') }}</flux:heading>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage profile details and access permissions for {{ $user->name }}.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $user->status === 'active' ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800' : 'bg-zinc-100 text-zinc-800 border-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700' }}">
                    {{ ucfirst($user->status) }}
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Avatar & Basic Identity -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-24 h-24 mb-4 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-2xl font-bold text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    {{ $user->initials() }}
                                @endif
                            </div>
                            <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $user->name }}</h3>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-4">{{ $user->email }}</p>
                            
                            <div class="w-full border-t border-zinc-100 dark:border-zinc-800 pt-4 mt-2 grid grid-cols-2 gap-2 text-center">
                                <div>
                                    <span class="block text-xs text-zinc-500">Joined</span>
                                    <span class="block text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-zinc-500">Last Login</span>
                                    <span class="block text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role & Status Card -->
                    <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm space-y-4">
                        <flux:heading size="sm" class="mb-2 border-b border-zinc-100 dark:border-zinc-800 pb-2">Access Control</flux:heading>
                        
                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" for="role">Role</label>
                            <select name="role" id="role" required class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                                <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" for="status">Status</label>
                            <select name="status" id="status" required class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="pt-2">
                            <flux:input name="account_type" label="Account Type" :value="old('account_type', $user->account_type)" />
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
                            <flux:input name="first_name" label="First Name" :value="old('first_name', $user->first_name)" />
                            <flux:input name="middle_name" label="Middle Name" :value="old('middle_name', $user->middle_name)" />
                            <flux:input name="last_name" label="Last Name" :value="old('last_name', $user->last_name)" />
                            <flux:input name="name" label="Display Name" required description="Name displayed on public profile" :value="old('name', $user->name)" />
                            
                            <div class="md:col-span-2">
                                <flux:input name="phone_number" label="Phone Number" :value="old('phone_number', $user->phone_number)" />
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
                            <flux:input name="email" label="Email Address" type="email" required :value="old('email', $user->email)" />
                            <flux:input name="username" label="Username" :value="old('username', $user->username)" />
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Security</h2>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Update password to secure the account.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <flux:input name="password" label="New Password" type="password" placeholder="Leave blank to keep current" />
                            <flux:input name="password_confirmation" label="Confirm Password" type="password" placeholder="Re-enter new password" />
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4">
                        <flux:button variant="ghost" :href="route('users.index')" wire:navigate class="!bg-transparent hover:!bg-zinc-100 dark:hover:!bg-zinc-800">{{ __('Cancel') }}</flux:button>
                        <flux:button type="submit" variant="primary" class="min-w-[120px]">{{ __('Save Changes') }}</flux:button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
