<x-layouts.app>
    <div class="mb-6 flex items-center justify-between">
        <flux:heading size="xl">{{ __('User Details') }}</flux:heading>
        <div class="flex gap-2">
            <flux:button variant="ghost" :href="route('users.index')" wire:navigate>{{ __('Back to List') }}</flux:button>
            @can('edit-users')
                <flux:button variant="primary" :href="route('users.edit', $user->id)" wire:navigate>{{ __('Edit User') }}</flux:button>
            @endcan
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1">
            <flux:card>
                <div class="flex flex-col items-center text-center">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full mb-4">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-4xl font-bold text-gray-600 mb-4">
                            {{ $user->initials() }}
                        </div>
                    @endif
                    <flux:heading size="lg">{{ $user->name }}</flux:heading>
                    <flux:text>{{ $user->email }}</flux:text>
                    <div class="mt-4 flex gap-2">
                        <flux:badge :color="$user->role === 'admin' ? 'red' : 'zinc'">{{ ucfirst($user->role) }}</flux:badge>
                        <flux:badge :color="$user->status === 'active' ? 'green' : 'red'">{{ ucfirst($user->status) }}</flux:badge>
                    </div>
                </div>
            </flux:card>
        </div>

        <div class="col-span-2">
            <flux:card class="space-y-6">
                <div>
                    <flux:heading size="lg" class="mb-4">{{ __('Personal Information') }}</flux:heading>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">First Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->first_name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Middle Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->middle_name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->last_name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Username</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->username ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->phone_number ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Account Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->account_type ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <flux:separator />

                <div>
                    <flux:heading size="lg" class="mb-4">{{ __('Audit Information') }}</flux:heading>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created By</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->creator ? $user->creator->name : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('F j, Y g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Updated By</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->updater ? $user->updater->name : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->last_login_at ? $user->last_login_at->format('F j, Y g:i A') : 'Never' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Password Last Changed</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->password_changed_at ? $user->password_changed_at->format('F j, Y g:i A') : 'Never' }}</dd>
                        </div>
                    </dl>
                </div>
            </flux:card>
        </div>
    </div>
</x-layouts.app>
