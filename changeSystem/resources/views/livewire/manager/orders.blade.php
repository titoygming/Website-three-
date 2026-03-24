@use(App\Enums\OrderStatus)

<div>
    <x-ts-loading />
    <header class="mb-5">
        <flux:heading size="xl" level="1">Orders Management</flux:heading>
        <flux:text class="mt-2 mb-6 text-base">Manage customers orders</flux:text>
        <flux:separator variant="subtle" />
    </header>

    <x-ts-table :headers="[
        ['index' => 'id', 'label' => '# Ref'],
        ['index' => 'service.name', 'label' => 'Service name'],
        ['index' => 'amount', 'label' => 'Credit'],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'user.name', 'label' => 'Order by'],
        ['index' => 'actions', 'label' => 'Actions'],
    ]" :quantity="[5, 10, 25, 50]" :rows="$this->orders" filter paginate>


        @interact('column_status', $row)
            <x-ts-badge :text="$row->status->value" :color="$row->status->color()" />
        @endinteract

        @interact('column_actions', $row)
            @if ($row->status == OrderStatus::PENDING)
                <flux:tooltip content="Accept order">
                    <x-ts-button.circle wire:click="acceptOrder('{{ $row->id }}')" flat icon="check-circle"
                        color="green" />
                </flux:tooltip>
                <flux:tooltip content="Reject order">
                    <x-ts-button.circle wire:click="rejectOrder('{{ $row->id }}')" flat icon="x-mark"
                        color="red" />
                </flux:tooltip>
            @elseif ($row->status == OrderStatus::ACCEPTED)
                <flux:tooltip content="Finilize order">
                    <x-ts-button.circle wire:click="doneOrder('{{ $row->id }}')" flat icon="check-badge"
                        color="green" />
                </flux:tooltip>
                <flux:tooltip content="Cancel order">
                    <x-ts-button.circle wire:click="cancelOrder('{{ $row->id }}')" flat icon="x-mark"
                        color="red" />
                </flux:tooltip>
            @endif
        @endinteract


        <x-slot::empty>
            <div class="flex flex-col items-center gap-2 py-6">
                <flux:icon name="shopping-cart" class="size-8 text-zinc-400" />
                <p class="text-sm text-zinc-500">
                    {{ __('No orders found.') }}
                </p>
                <x-ts-button wire:click="$toggle('takeorder')" icon="plus" color="green" sm>
                    {{ __('Take order') }}
                </x-ts-button>
            </div>
        </x-slot::empty>
    </x-ts-table>
</div>
