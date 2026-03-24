<div class="p-4">
    <div class="my-4 flex items-center justify-between">
        <header>
            <h2 class="text-2xl font-semibold tracking-tight">
                {{ __('My Orders') }}
            </h2>
            <p class="mt-1 text-sm text-zinc-500">
                {{ __('Manage your orders on the platform.') }}
            </p>
        </header>
        <div class="mt-4 flex items-center gap-2">
            <x-ts-button wire:click="$toggle('takeorder')" icon="plus" color="green" sm>
                {{ __('Take order') }}
            </x-ts-button>
        </div>
    </div>

    <x-ts-table :rows="$this->orders" :headers="[
        ['label' => __('Name'), 'index' => 'device.name'],
        ['label' => __('Imei/sn'), 'index' => 'device.imei'],
        ['label' => __('Model'), 'index' => 'device.model'],
        ['label' => __('Service name'), 'index' => 'service.name'],
        ['label' => __('Credit'), 'index' => 'amount'],
        ['label' => __('Status'), 'index' => 'status'],
        ['label' => __('Ordered at'), 'index' => 'created_at'],
    ]" :quantity="[5, 10, 25, 50]" filter paginate>

        @interact('column_status', $row)
            <x-ts-badge :text="$row->status->value" :color="$row->status->color()" />
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

    <x-ts-modal :title="__('Add Device')" id="take-device" wire="takeorder" center>
        <div class="space-y-4">
            <div class="my-3">
                <x-ts-select.styled label="Service" :options="$this->services" wire:model.live="serviceId" searchable />
                @if ($this->serviceId)
                    <p class="my-3">Service credit: {{ (int) $this->service?->price }}</p>
                @endif
            </div>
            <div class="my-3">
                <x-ts-select.styled label="Device" :options="$this->devices" wire:model="deviceId" searchable />
            </div>
        </div>
        <x-slot::footer>
            <div class="flex items-center justify-end gap-2">
                <x-ts-button color="red" flat sm wire:click="$set('takeorder', false)">
                    {{ __('Cancel') }}
                </x-ts-button>
                <x-ts-button wire:click="takeOrder" color="green" sm>
                    {{ __('Take order') }}
                </x-ts-button>
            </div>
        </x-slot::footer>
    </x-ts-modal>
</div>
