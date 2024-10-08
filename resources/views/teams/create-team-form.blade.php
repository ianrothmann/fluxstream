<div class="flex flex-row">
    <div class="basis-4/12 p-2">
        <h3 class="text-lg font-medium text-gray-900">
            {{ __('Team Details') }}
        </h3>

        <h2 class="mt-1 text-sm text-gray-600">
            {{ __('Create a new team to collaborate with others on projects.') }}
        </h2>
    </div>

    <div class="basis-8/12">
        <flux:card>
            <div class="col-span-6">
                <x-label value="{{ __('Team Owner') }}"/>

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" src="{{ $this->user->profile_photo_url }}"
                         alt="{{ $this->user->name }}">

                    <div class="ms-4 leading-tight">
                        <div class="text-gray-900">{{ $this->user->name }}</div>
                        <div class="text-gray-700 text-sm">{{ $this->user->email }}</div>
                    </div>
                </div>
            </div>

            <form class="mt-2">
                <flux:fieldset class="mb-3">
                    <flux:field class="col-span-6 sm:col-span-4"
                    >
                        <flux:label>{{ __('Team Name') }}</flux:label>

                        <flux:input wire:model="state.name"/>

                        <flux:error name="name"/>
                    </flux:field>
                </flux:fieldset>

                <div class="flex justify-end">
                    <flux:button variant="primary"
                                 wire:click.prevent="createTeam"
                    >
                        {{ __('Create') }}
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</div>
