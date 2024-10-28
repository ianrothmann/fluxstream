<x-layouts.app>
    <flux:heading size="xl">
        {{ __('Create Team') }}
    </flux:heading>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        @livewire('teams.create-team-form')
    </div>
</x-layouts.app>
