<x-layouts.app>
    <flux:heading size="xl">
        {{ __('API Tokens') }}
    </flux:heading>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('api.api-token-manager')
        </div>
    </div>
</x-layouts.app>
