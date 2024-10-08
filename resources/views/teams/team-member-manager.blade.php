<div>
    @if (Gate::check('addTeamMember', $team))

        <flux:separator class="my-5"/>

        <!-- Add Team Member -->
        <div class="flex flex-row">
            <div class="basis-4/12 p-2">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('Add Team Member') }}
                </h3>

                <h2 class="mt-1 text-sm text-gray-600">
                    {{ __('Add a new team member to your team, allowing them to collaborate with you.') }}
                </h2>
            </div>

            <div class="basis-8/12">
                <form>
                    <flux:card>
                        <div class="max-w-xl text-sm text-gray-600">
                            {{ __('Please provide the email address of the person you would like to add to this team.') }}
                        </div>

                        <!-- Member Email -->
                        <flux:fieldset class="mb-3">
                            <flux:field class="col-span-6 sm:col-span-4"
                            >
                                <flux:label>{{ __('Email') }}</flux:label>

                                <flux:input wire:model="addTeamMemberForm.email"/>

                                <flux:error name="email"/>
                            </flux:field>
                        </flux:fieldset>

                        <!-- Role -->
                        @if (count($this->roles) > 0)
                            <div class="col-span-6 lg:col-span-4">
                                <x-label for="role" value="{{ __('Role') }}"/>
                                <x-input-error for="role" class="mt-2"/>

                                <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                                    @foreach ($this->roles as $index => $role)
                                        <button type="button"
                                                class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 {{ $index > 0 ? 'border-t border-gray-200 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                                wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')">
                                            <div
                                                class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                                <!-- Role Name -->
                                                <div class="flex items-center">
                                                    <div
                                                        class="text-sm text-gray-600 {{ $addTeamMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                                        {{ $role->name }}
                                                    </div>

                                                    @if ($addTeamMemberForm['role'] == $role->key)
                                                        <svg class="ms-2 h-5 w-5 text-green-400"
                                                             xmlns="http://www.w3.org/2000/svg" fill="none"
                                                             viewBox="0 0 24 24" stroke-width="1.5"
                                                             stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    @endif
                                                </div>

                                                <!-- Role Description -->
                                                <div class="mt-2 text-xs text-gray-600 text-start">
                                                    {{ $role->description }}
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Action--}}
                        @if (Gate::check('update', $team))
                            <div class="flex space-x-4 items-center justify-end bg-gray-50 -mx-6 -mb-6 mt-6 p-2"
                                 style="border-bottom-right-radius: inherit; border-bottom-left-radius: inherit"
                            >
                                <flux:button variant="primary"
                                             wire:click.prevent="addTeamMember"
                                >
                                    {{ __('Add') }}
                                </flux:button>

                                <x-action-message class="me-3" on="saved">
                                    {{ __('Added.') }}
                                </x-action-message>
                            </div>
                        @endif
                    </flux:card>
                </form>
            </div>
        </div>
    @endif

    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
        <flux:separator class="my-5"/>

        <!-- Team Member Invitations -->
        <div class="flex flex-row">
            <div class="basis-4/12 p-2">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('Pending Team Invitations') }}
                </h3>

                <h2 class="mt-1 text-sm text-gray-600">
                    {{ __('These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.') }}
                </h2>
            </div>

            <div class="basis-8/12">
                <flux:card>
                    @foreach ($team->teamInvitations as $index => $invitation)
                        <div
                            class="flex items-center justify-between"
                            wire:key="token-{{ $index }}"
                        >
                            <div class="break-all">
                                {{ $invitation->email }}
                            </div>

                            <div class="flex items-center">
                                @if (Gate::check('removeTeamMember', $team))
                                    <!-- Cancel Team Invitation -->
                                    <flux:button variant="danger"
                                                 wire:click="cancelTeamInvitation({{ $invitation->id }})"
                                    >
                                        {{ __('Cancel') }}
                                    </flux:button>
                                @endif
                            </div>
                        </div>

                        @if(sizeof($team->teamInvitations) - 1 > $index)
                            <flux:separator class="my-3"/>
                        @endif
                    @endforeach
                </flux:card>
            </div>
        </div>
    @endif

    @if ($team->users->isNotEmpty())
        <flux:separator class="my-5"/>

        <!-- Manage Team Members -->
        <div class="flex flex-row">
            <div class="basis-4/12 p-2">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('Team Members') }}
                </h3>

                <h2 class="mt-1 text-sm text-gray-600">
                    {{ __('All of the people that are part of this team.') }}
                </h2>
            </div>

            <div class="basis-8/12">
                <flux:card>
                    @foreach ($team->users->sortBy('name') as $index=>$user)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}"
                                     alt="{{ $user->name }}">
                                <div class="ms-4">{{ $user->name }}</div>
                            </div>

                            <div class="flex items-center">
                                <!-- Manage Team Member Role -->
                                <div class="me-1">
                                    @if (Gate::check('updateTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                                        <flux:button variant="ghost"
                                                     wire:click="manageRole('{{ $user->id }}')"
                                        >
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                        </flux:button>
                                    @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                        <div class="ms-2 text-sm text-gray-400">
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Leave Team -->
                                @if ($this->user->id === $user->id)
                                    <flux:button variant="danger"
                                                 wire:click="$toggle('confirmingLeavingTeam')"
                                    >
                                        {{ __('Leave') }}
                                    </flux:button>
                                @elseif (Gate::check('removeTeamMember', $team))
                                    <!-- Remove Team Member -->
                                    <flux:button variant="danger"
                                                 wire:click="confirmTeamMemberRemoval('{{ $user->id }}')"
                                    >
                                        {{ __('Remove') }}
                                    </flux:button>
                                @endif
                            </div>
                        </div>

                        @if(sizeof($team->users) - 1 > $index)
                            <flux:separator class="my-3"/>
                        @endif
                    @endforeach
                </flux:card>
            </div>
        </div>
    @endif

    <!-- Role Management Modal -->
    <flux:modal wire:model.self="currentlyManagingRole"
                class="w-[50%] space-y-6"
    >
        <flux:heading size="lg">
            {{ __('Manage Role') }}
        </flux:heading>

        <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
            @foreach ($this->roles as $index => $role)
                <button type="button"
                        class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 {{ $index > 0 ? 'border-t border-gray-200 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                        wire:click="$set('currentRole', '{{ $role->key }}')">
                    <div class="{{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                        <!-- Role Name -->
                        <div class="flex items-center">
                            <div
                                class="text-sm text-gray-600 {{ $currentRole == $role->key ? 'font-semibold' : '' }}">
                                {{ $role->name }}
                            </div>

                            @if ($currentRole == $role->key)
                                <svg class="ms-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>

                        <!-- Role Description -->
                        <div class="mt-2 text-xs text-gray-600">
                            {{ $role->description }}
                        </div>
                    </div>
                </button>
            @endforeach
        </div>

        <div class="flex">
            <flux:button wire:click="stopManagingRole"
            >
                {{ __('Cancel') }}
            </flux:button>

            <flux:spacer/>

            <flux:button variant="primary"
                         wire:click="updateRole"
                         class="ms-3"
            >
                {{ __('Save') }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Leave Team Confirmation Modal -->
    <flux:modal wire:model.self="confirmingLeavingTeam"
                class="w-[50%] space-y-6"
    >
        <flux:heading size="lg">
            {{ __('Leave Team') }}
        </flux:heading>

        <flux:subheading>
            {{ __('Are you sure you would like to leave this team?') }}
        </flux:subheading>

        <div class="flex">
            <flux:button wire:click="$toggle('confirmingLeavingTeam')"
            >
                {{ __('Cancel') }}
            </flux:button>

            <flux:spacer/>

            <flux:button variant="danger"
                         wire:click="leaveTeam"
                         class="ms-3"
            >
                {{ __('Leave') }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Remove Team Member Confirmation Modal -->
    <flux:modal wire:model.self="confirmingTeamMemberRemoval"
                class="w-[50%] space-y-6"
    >
        <flux:heading size="lg">
            {{ __('Remove Team Member') }}
        </flux:heading>

        <flux:subheading>
            {{ __('Are you sure you would like to remove this person from the team?') }}
        </flux:subheading>

        <div class="flex">
            <flux:button wire:click="$toggle('confirmingTeamMemberRemoval')"
            >
                {{ __('Cancel') }}
            </flux:button>

            <flux:spacer/>

            <flux:button variant="danger"
                         wire:click="removeTeamMember"
                         class="ms-3"
            >
                {{ __('Remove') }}
            </flux:button>
        </div>
    </flux:modal>
</div>
