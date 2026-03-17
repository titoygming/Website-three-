<div class="p-4">
    <div class="my-4 flex items-center justify-between">
        <header>
            <h2 class="text-2xl font-semibold tracking-tight">
                {{ __('My transactions') }}
            </h2>
            <p class="mt-1 text-sm text-zinc-500">
                {{ __('Manage your transactions on the platform.') }}
            </p>
        </header>
    </div>

    <x-ts-table :rows="$this->transactions" :headers="[
        ['label' => __('Type'), 'index' => 'type'],
        ['label' => __('Amount'), 'index' => 'amount'],
        ['label' => __('Created_at'), 'index' => 'created_at'],
    ]" :quantity="[5, 10, 25, 50]" filter paginate>

        @interact('column_type', $row)
            @if ($row->type->value == 'credit')
                <p class="text-green-500">{{ $row->amount }}</p>
            @else
                <p class="text-red-500">{{ $row->amount }}</p>
            @endif
        @endinteract

        @interact('column_amount', $row)
            <x-ts-badge :text="$row->type->value" :color="$row->type->value == 'credit' ? 'green' : 'red'" />
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
