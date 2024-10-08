<flux:header container
             class="pt-2 border-b bg-zinc-50 border-zinc-200 lg:pt-0">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2"/>

    <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc."
                class="max-lg:hidden"/>
    <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
                class="max-lg:!hidden hidden"/>

    <flux:navbar class="max-lg:hidden">
        <flux:navbar.item icon="home"
                          href="/"
                          wire:navigate
        >
            Home
        </flux:navbar.item>
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
                <flux:navmenu.item href="/teams/{{ Auth::user()->currentTeam->id }}"
                                   wire:navigate
                >
                    {{ __('Team Settings') }}
                </flux:navmenu.item>
                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                    <flux:navmenu.item href="/teams/create"
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
        <flux:button icon-trailing="chevron-down"
                     variant="ghost"
        >
            {{ auth()->user()->name }}
        </flux:button>

        <flux:navmenu>
            <flux:navmenu.item href="/profile"
                               wire:navigate
                               icon="building-storefront"
            >
                Profile
            </flux:navmenu.item>

            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <flux:navmenu.item href="/user/api-tokens"
                                   wire:navigate
                                   icon="globe-alt"
                >
                    {{ __('API Tokens') }}
                </flux:navmenu.item>
            @endif

            <flux:navmenu.item wire:click='logout'
                               icon="arrow-right-start-on-rectangle"
            >
                Logout
            </flux:navmenu.item>
        </flux:navmenu>
    </flux:dropdown>
</flux:header>
