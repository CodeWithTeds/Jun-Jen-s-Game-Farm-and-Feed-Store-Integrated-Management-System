<x-layouts.app>
    <div class="max-w-5xl mx-auto py-6">
        <!-- Header & Navigation -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('users.index') }}" wire:navigate class="p-2 -ml-2 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <span class="material-icons text-[20px]">arrow_back</span>
                </a>
                <div>
                    <flux:heading size="xl" class="leading-tight">{{ __('User Details') }}</flux:heading>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">View complete profile and activity logs.</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @can('edit-users')
                    <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center justify-center rounded-lg text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none ring-offset-background bg-zinc-900 text-zinc-50 hover:bg-zinc-900/90 dark:bg-zinc-50 dark:text-zinc-900 dark:hover:bg-zinc-50/90 h-10 px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil mr-2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                        {{ __('Edit User') }}
                    </a>
                @endcan
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Profile Card -->
            <div class="lg:col-span-1 space-y-6">
                <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-32 h-32 mb-4 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-3xl font-bold text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                            @else
                                {{ $user->initials() }}
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ $user->name }}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">{{ $user->email }}</p>
                        
                        <div class="flex flex-wrap justify-center gap-2 mb-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $user->status === 'active' ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800' : 'bg-zinc-100 text-zinc-800 border-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <div class="w-full border-t border-zinc-100 dark:border-zinc-800 pt-4 grid grid-cols-2 gap-4 text-center">
                            <div>
                                <span class="block text-xs text-zinc-500 uppercase tracking-wider">Joined</span>
                                <span class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-zinc-500 uppercase tracking-wider">Type</span>
                                <span class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ ucfirst($user->account_type ?? 'Standard') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                        <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Personal Information') }}</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                            <div>
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Full Name</dt>
                                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Username</dt>
                                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->username ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Phone Number</dt>
                                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->phone_number ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Email</dt>
                                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">First Name</dt>
                                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->first_name ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Name</dt>
                                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->last_name ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- System Activity -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                        <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">{{ __('System Activity & Audit') }}</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                            <div>
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Created By</dt>
                                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $user->creator ? $user->creator->name : 'System' }}
                                    <span class="text-zinc-400 font-normal text-xs block">{{ $user->created_at->format('F j, Y g:i A') }}</span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Updated</dt>
                                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $user->updater ? $user->updater->name : 'System' }}
                                    <span class="text-zinc-400 font-normal text-xs block">{{ $user->updated_at->format('F j, Y g:i A') }}</span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Login</dt>
                                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $user->last_login_at ? $user->last_login_at->format('F j, Y g:i A') : 'Never' }}
                                    @if($user->last_login_at)
                                        <span class="text-zinc-400 font-normal text-xs block">{{ $user->last_login_at->diffForHumans() }}</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Password Last Changed</dt>
                                <dd class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $user->password_changed_at ? $user->password_changed_at->format('F j, Y g:i A') : 'Never' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
