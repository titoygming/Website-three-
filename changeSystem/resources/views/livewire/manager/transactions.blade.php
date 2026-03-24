@use(App\Enums\TransactionType)

<div>
    <x-ts-loading />
    <header class="mb-5">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">Transactions Management</flux:heading>
                <flux:text class="mt-2 mb-6 text-base">Manage transactions</flux:text>
            </div>
        </div>
        <flux:separator variant="subtle" />
    </header>

    <x-ts-table :headers="[
        ['index' => 'id', 'label' => '# REF'],
        ['index' => 'amount', 'label' => 'Amount'],
        ['index' => 'type', 'label' => 'Type'],
        ['index' => 'user.name', 'label' => 'User'],
        ['index' => 'user.email', 'label' => 'Email'],
        ['index' => 'created_at', 'label' => 'Created at'],
    ]" :rows="$this->transactions" :quantity="[5, 10, 25, 50]" filter paginate>

        @interact('column_email', $row)
            <p>{{ str($row->email)->mask('*', 3, 4) }}</p>
        @endinteract

        @interact('column_amount', $row)
            @if ($row->type->value == 'credit')
                <p class="text-green-500">{{ $row->amount }}</p>
            @else
                <p class="text-red-500">{{ $row->amount }}</p>
            @endif
        @endinteract

        @interact('column_type', $row)
            <x-ts-badge :text="$row->type->value" :color="$row->type->value == 'credit' ? 'green' : 'red'" />
        @endinteract

        <x-slot::empty>
            <div class="flex flex-col items-center gap-2 py-6">
                <flux:icon name="wallet" class="size-8 text-zinc-400" />
                <p class="text-sm text-zinc-500">
                    {{ __('Transactions not found') }}
                </p>
            </div>
        </x-slot::empty>
    </x-ts-table>
</div>
