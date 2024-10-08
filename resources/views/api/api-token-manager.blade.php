<div>

    <!-- Generate API Token -->
    <div class="flex flex-row">
        <div class="basis-4/12 p-2">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Create API Token') }}
            </h3>

            <h2 class="mt-1 text-sm text-gray-600 dark:text-white/70">
                {{ __('API tokens allow third-party services to authenticate with our application on your behalf.') }}
            </h2>
        </div>

        <div class="basis-8/12">
            <form>
                <flux:card>
                    <flux:fieldset>
                        {{-- Token Name --}}
                        <flux:field class="col-span-6 sm:col-span-4">
                            <flux:label>{{__('Token Name')}}</flux:label>

                            <flux:input wire:model="createApiTokenForm.name"/>

                            <flux:error name="name"/>
                        </flux:field>

                        {{-- Permissions --}}
                        @if (Laravel\Jetstream\Jetstream::hasPermissions())
                            <div class="col-span-6">
                                <flux:checkbox.group wire:model="createApiTokenForm.permissions"
                                                     label="{{ __('Permissions') }}"
                                >
                                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                                            <flux:checkbox label="{{$permission}}"
                                                           value="{{$permission}}"/>
                                        @endforeach
                                    </div>
                                </flux:checkbox.group>
                            </div>
                        @endif
                    </flux:fieldset>

                    {{-- Action--}}
                    <div
                        class="flex space-x-4 items-center justify-end bg-gray-50 dark:bg-zinc-800 -mx-6 -mb-6 mt-6 p-2"
                        style="border-bottom-right-radius: inherit; border-bottom-left-radius: inherit"
                    >
                        <flux:button variant="primary"
                                     wire:click.prevent="createApiToken"
                                     wire:loading.attr="disabled"
                        >
                            {{ __('Creat') }}
                        </flux:button>

                        <x-action-message class="me-3" on="saved">
                            {{ __('Created.') }}
                        </x-action-message>
                    </div>
                </flux:card>
            </form>
        </div>
    </div>


    @if ($this->user->tokens->isNotEmpty())
        <flux:separator class="my-5"/>

        <div class="flex flex-row">
            <div class="basis-4/12 p-2">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ __('Manage API Tokens') }}
                </h3>

                <h2 class="mt-1 text-sm text-gray-600 dark:text-white/70">
                    {{ __('You may delete any of your existing tokens if they are no longer needed.') }}
                </h2>
            </div>

            <div class="basis-8/12">
                <flux:card>
                    @foreach ($this->user->tokens->sortBy('name') as $index => $token)
                        <div
                            class="flex items-center justify-between {{sizeof($this->user->tokens) - 1 <= $index ? '' : 'mb-3'}}"
                            wire:key="token-{{ $index }}"
                        >
                            <div class="break-all dark:text-white">
                                {{ $token->name }}
                            </div>

                            <div class="flex items-center ms-2">
                                @if ($token->last_used_at)
                                    <div class="text-sm text-gray-400">
                                        {{ __('Last used') }} {{ $token->last_used_at->diffForHumans() }}
                                    </div>
                                @endif

                                @if (Laravel\Jetstream\Jetstream::hasPermissions())
                                    <flux:button variant="ghost"
                                                 wire:click="manageApiTokenPermissions({{ $token->id }})"
                                    >
                                        {{ __('Permissions') }}
                                    </flux:button>
                                @endif
                                <flux:button variant="danger"
                                             wire:click="confirmApiTokenDeletion({{ $token->id }})"
                                             class="ml-3"
                                >
                                    {{ __('Delete') }}
                                </flux:button>
                            </div>
                        </div>
                    @endforeach
                </flux:card>
            </div>
        </div>
    @endif

    <!-- Token Value Modal -->
    <flux:modal wire:model.self="displayingToken"
                class="w-[50%] space-y-6"
    >
        <flux:heading size="lg">
            {{ __('API Token') }}
        </flux:heading>

        <flux:subheading>
            {{ __('Please copy your new API token. For your security, it won\'t be shown again.') }}
        </flux:subheading>

        <flux:input icon="key"
                    value="{{$plainTextToken}}"
                    readonly
                    copyable
        />

        <flux:button wire:click="$set('displayingToken', false)"
        >
            {{ __('Close') }}
        </flux:button>
    </flux:modal>

    {{--API Token Permissions Modal--}}
    <flux:modal wire:model.self="managingApiTokenPermissions"
                class="w-[50%] space-y-6"
    >
        <flux:heading size="lg">
            {{ __('API Token Permissions') }}
        </flux:heading>

        <flux:checkbox.group wire:model="updateApiTokenForm.permissions"
                             label="{{ __('Permissions') }}"
        >
            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                    <flux:checkbox label="{{$permission}}"
                                   value="{{$permission}}"/>
                @endforeach
            </div>
        </flux:checkbox.group>

        <div class="flex">
            <flux:button wire:click="$set('managingApiTokenPermissions', false)"
            >
                {{ __('Cancel') }}
            </flux:button>

            <flux:spacer/>

            <flux:button variant="primary"
                         wire:click="updateApiToken"
                         class="ms-3"
            >
                {{ __('Save') }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Delete Token Confirmation Modal -->
    <flux:modal wire:model.self="confirmingApiTokenDeletion"
                class="w-[50%] space-y-6"
    >
        <flux:heading size="lg">
            {{ __('Delete API Token') }}
        </flux:heading>

        <flux:subheading>
            {{ __('Are you sure you would like to delete this API token?') }}
        </flux:subheading>

        <div class="flex">
            <flux:button wire:click="$toggle('confirmingApiTokenDeletion')"
            >
                {{ __('Cancel') }}
            </flux:button>

            <flux:spacer/>

            <flux:button variant="danger"
                         wire:click="deleteApiToken"
                         class="ms-3"
            >
                {{ __('Delete') }}
            </flux:button>
        </div>
    </flux:modal>
</div>
