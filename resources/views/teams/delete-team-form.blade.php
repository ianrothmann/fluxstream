<div class="flex flex-row">
    <div class="basis-4/12 p-2">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('Delete Team') }}
        </h3>

        <h2 class="mt-1 text-sm text-gray-600 dark:text-white/70">
            {{ __('Permanently delete this team.') }}
        </h2>
    </div>

    <div class="basis-8/12">
        <flux:card>
            <div class="max-w-xl text-sm text-gray-600 dark:text-white/70">
                {{ __('Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.') }}
            </div>

            <div class="flex justify-end mt-2">
                <flux:button variant="danger"
                             wire:click="$toggle('confirmingTeamDeletion')"
                >
                    {{ __('Delete Team') }}
                </flux:button>
            </div>
        </flux:card>
    </div>

    <!-- Delete Team Confirmation Modal -->
    <flux:modal wire:model.self="confirmingTeamDeletion"
                class="w-[50%] space-y-6"
    >
        <flux:heading size="lg">
            {{ __('Delete Team') }}
        </flux:heading>

        <flux:subheading>
            {{ __('Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.') }}
        </flux:subheading>

        <div class="flex">
            <flux:button wire:click="$toggle('confirmingTeamDeletion')"
            >
                {{ __('Cancel') }}
            </flux:button>

            <flux:spacer/>

            <flux:button variant="danger"
                         wire:click="deleteTeam"
                         class="ms-3"
            >
                {{ __('Delete Team') }}
            </flux:button>
        </div>
    </flux:modal>
</div>
