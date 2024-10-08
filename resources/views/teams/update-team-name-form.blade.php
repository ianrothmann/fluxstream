<div class="flex flex-row">
    <div class="basis-4/12">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('Team Name') }}
        </h3>

        <h2 class="mt-1 text-sm text-gray-600 dark:text-white/70">
            {{ __('The team\'s name and owner information.') }}
        </h2>
    </div>

    <div class="basis-8/12">
        <form>
            <flux:card>
                <!-- Team Owner Information -->
                <div class="col-span-6">
                    <x-label class="dark:text-white"
                             value="{{ __('Team Owner') }}"
                    />

                    <div class="flex items-center mt-2">
                        <img class="w-12 h-12 rounded-full object-cover"
                             src="{{ $team->owner->profile_photo_url }}"
                             alt="{{ $team->owner->name }}">

                        <div class="ms-4 leading-tight">
                            <div class="text-gray-900 dark:text-white">
                                {{ $team->owner->name }}
                            </div>
                            <div class="text-gray-700 text-sm dark:text-white/70">
                                {{ $team->owner->email }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Name -->
                <flux:fieldset class="mt-3">
                    <flux:label>{{ __('Team Name') }}</flux:label>

                    <flux:input wire:model="state.name"
                                :disabled="!Gate::check('update', $team)"
                    />

                    <flux:error name="name"/>
                </flux:fieldset>

                {{-- Action--}}
                @if (Gate::check('update', $team))
                    <div
                        class="flex space-x-4 items-center justify-end bg-gray-50 -mx-6 -mb-6 mt-6 p-2 dark:bg-zinc-800"
                        style="border-bottom-right-radius: inherit; border-bottom-left-radius: inherit"
                    >
                        <flux:button variant="primary"
                                     wire:click.prevent="updateTeamName"
                        >
                            {{ __('Save') }}
                        </flux:button>

                        <x-action-message class="me-3" on="saved">
                            {{ __('Saved.') }}
                        </x-action-message>
                    </div>
                @endif
            </flux:card>
        </form>
    </div>
</div>
