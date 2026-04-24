<div class="flex items-start max-md:flex-col gap-8">
    <!-- Sidebar Navigation -->
    <div class="w-full md:w-[220px] flex-shrink-0">
        <div class="card-glass p-4 rounded-lg">
            <flux:navlist aria-label="{{ __('Settings') }}" class="space-y-2">
                <flux:navlist.item :href="route('profile.edit')" wire:navigate class="hover:bg-red-100 data-[current]:bg-red-500 data-[current]:text-white rounded-lg transition-colors">
                    👤 {{ __('Profile') }}
                </flux:navlist.item>
                <flux:navlist.item :href="route('security.edit')" wire:navigate class="hover:bg-green-100 data-[current]:bg-green-500 data-[current]:text-white rounded-lg transition-colors">
                    🔒 {{ __('Security') }}
                </flux:navlist.item>
                <flux:navlist.item :href="route('appearance.edit')" wire:navigate class="hover:bg-yellow-100 data-[current]:bg-yellow-500 data-[current]:text-zinc-900 rounded-lg transition-colors">
                    🎨 {{ __('Appearance') }}
                </flux:navlist.item>
            </flux:navlist>
        </div>
    </div>

    <flux:separator class="md:hidden" />

    <!-- Content Area -->
    <div class="flex-1 self-stretch max-md:pt-6">
        <div class="card-glass-lg p-6 md:p-8 rounded-lg">
            <flux:heading class="text-2xl md:text-3xl font-bold text-zinc-900 mb-2">{{ $heading ?? '' }}</flux:heading>
            <flux:subheading class="text-zinc-600 mb-6">{{ $subheading ?? '' }}</flux:subheading>

            <div class="mt-5 w-full max-w-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
