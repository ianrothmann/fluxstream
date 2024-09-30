<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
};
?>

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'My Laravel App') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxStyles
</head>

<body class="min-h-screen bg-white">
<flux:header container
             class="pt-2 border-b bg-zinc-50 border-zinc-200 lg:pt-0">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2"/>

    <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc."
                class="max-lg:hidden"/>
    <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
                class="max-lg:!hidden hidden"/>

    <flux:navbar class="max-lg:hidden">
        <flux:navbar.item icon="home" href="/" wire:navigate>Home</flux:navbar.item>
        <flux:separator vertical variant="subtle" class="my-2"/>
        <flux:navbar.item icon="face-smile" href="/playground" wire:navigate>Playground</flux:navbar.item>

    </flux:navbar>

    <flux:spacer/>

    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
        <flux:dropdown position="bottom"
                       align="end"
        >
            <flux:button icon-trailing="chevron-down"
                         variant="ghost">
                {{ Auth::user()->currentTeam->name }}
            </flux:button>

            <flux:navmenu>
                <!-- Team Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Manage Team') }}
                </div>
                <!-- Team Settings -->
                <flux:navmenu.item href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                                   wire:navigate
                >
                    {{ __('Team Settings') }}
                </flux:navmenu.item>
                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                    <flux:navmenu.item href="{{ route('teams.create') }}"
                                       wire:navigate
                    >
                        {{ __('Create New Team') }}
                    </flux:navmenu.item>
                @endcan

                <!-- Team Switcher -->
                @if (Auth::user()->allTeams()->count() > 1)
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-switchable-team :team="$team"/>
                    @endforeach
                @endif

            </flux:navmenu>
        </flux:dropdown>
    @endif


    <flux:dropdown position="bottom" align="end">
        <flux:button icon-trailing="chevron-down" variant="ghost">{{ auth()->user()->name }}</flux:button>

        <flux:navmenu>
            <flux:navmenu.item href="{{ route('profile.update') }}" wire:navigate icon="building-storefront">Profile
            </flux:navmenu.item>

            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <flux:navmenu.item href="{{ route('api-tokens.index') }}">
                    {{ __('API Tokens') }}
                </flux:navmenu.item>
            @endif

            <flux:navmenu.item wire:click='logout' icon="arrow-right-start-on-rectangle">Logout</flux:navmenu.item>
        </flux:navmenu>
    </flux:dropdown>
</flux:header>

<flux:sidebar stashable sticky
              class="border-r lg:hidden bg-zinc-50 border-zinc-200">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    <flux:brand href="/" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc."
                class="px-2"/>
    <flux:brand href="/" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
                class="hidden px-2"/>

    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="/">Home</flux:navlist.item>
        <flux:navlist.item icon="face-smile" href="/playground">Playground</flux:navlist.item>
    </flux:navlist>
</flux:sidebar>

<flux:main container>

    <div class="flex-1 self-stretch max-md:pt-6">
        {{ $slot }}
    </div>

</flux:main>
@persist('toast')
<flux:toast/>
@endpersist
@fluxScripts()
</body>

</html>
