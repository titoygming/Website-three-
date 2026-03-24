@use(App\Enums\UserStatus)
<div x-data="{}">
    <x-ts-loading />
    <header class="mb-5">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">Users Management</flux:heading>
                <flux:text class="mt-2 mb-6 text-base">Manage users accounts</flux:text>
            </div>
            <div>
                <x-ts-button x-on:click="$tsui.interaction('dialog').info('Info', 'Feature in development.').send()"
                    icon="user-plus" sm>
                    {{ __('Add user') }}
                </x-ts-button>
            </div>
        </div>
        <flux:separator variant="subtle" />
    </header>

    <x-ts-table :headers="[
        ['index' => 'name', 'label' => 'Name'],
        ['index' => 'email', 'label' => 'Email'],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'created_at', 'label' => 'Registed at'],
        ['index' => 'actions', 'label' => 'Actions'],
    ]" :rows="$this->users" :quantity="[5, 10, 25, 50]" filter paginate>

        @interact('column_email', $row)
            <p>{{ str($row->email)->mask('*', 3, 4) }}</p>
        @endinteract

        @interact('column_status', $row)
            <x-ts-badge :color="$row->status->color()" :text="str($row->status->value)->upper()" />
        @endinteract

        @interact('column_actions', $row)
            @if ($row->status == UserStatus::ACTIVE)
                <flux:tooltip content="Inactive user">
                    <x-ts-button.circle wire:click="inactiveUser('{{ $row->id }}')" icon="x-mark" color="red" flat />
                </flux:tooltip>
                <flux:tooltip content="Ban user">
                    <x-ts-button.circle wire:click="banUser('{{ $row->id }}')" icon="user-minus" color="red" flat />
                </flux:tooltip>
            @elseif ($row->status == UserStatus::BANNED)
                <flux:tooltip content="Unban user">
                    <x-ts-button.circle wire:click="unBanUser('{{ $row->id }}')" icon="user-plus" color="green" flat />
                </flux:tooltip>
            @elseif ($row->status == UserStatus::INACTIVE)
                <flux:tooltip content="Activate user">
                    <x-ts-button.circle wire:click="activeUser('{{ $row->id }}')" icon="check-circle" color="green" flat />
                </flux:tooltip>
                <flux:tooltip content="Ban user">
                    <x-ts-button.circle wire:click="banUser('{{ $row->id }}')" icon="user-minus" color="red" flat />
                </flux:tooltip>
            @endif
        @endinteract

        <x-slot::empty>
            <div class="flex flex-col items-center gap-2 py-6">
                <flux:icon name="users" class="size-8 text-zinc-400" />
                <p class="text-sm text-zinc-500">
                    {{ __('No users found.') }}
                </p>
            </div>
        </x-slot::empty>
    </x-ts-table>
</div>
