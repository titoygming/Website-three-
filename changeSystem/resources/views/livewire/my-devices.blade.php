<div class="p-4">
    <div class="my-4 flex items-center justify-between">
        <header>
            <h2 class="text-2xl font-semibold tracking-tight">
                {{ __('My Devices') }}
            </h2>
            <p class="mt-1 text-sm text-zinc-500">
                {{ __('Manage your devices registered on the platform.') }}
            </p>
        </header>
        <div class="mt-4 flex items-center gap-2">
            <x-ts-button wire:click="$toggle('newdevice')" icon="plus" color="green" sm>
                {{ __('Add Device') }}
            </x-ts-button>
        </div>
    </div>
    <x-ts-table :rows="$this->devices" :headers="[
        ['label' => __('Name'), 'index' => 'name'],
        ['label' => __('Imei/sn'), 'index' => 'imei'],
        ['label' => __('Model'), 'index' => 'model'],
        ['label' => __('Registed at'), 'index' => 'created_at'],
    ]" :quantity="[5, 10, 25, 50]" filter paginate>

        <x-slot::empty>
            <div class="flex flex-col items-center gap-2 py-6">
                <flux:icon name="device-phone-mobile" class="size-8 text-zinc-400" />
                <p class="text-sm text-zinc-500">
                    {{ __('No devices found.') }}
                </p>
                <x-ts-button wire:click="$toggle('newdevice')" icon="plus" color="green" sm>
                    {{ __('Add Device') }}
                </x-ts-button>
            </div>
        </x-slot::empty>
    </x-ts-table>

    <x-ts-modal :title="__('Add Device')" id="add-device" wire="newdevice" center>
        <div class="space-y-4">
            <x-ts-input wire:model="name" label="{{ __('Name') }} *" placeholder="{{ __('Device Name') }}" />
            <x-ts-input wire:model="imei" label="{{ __('IMEI/SN') }} *" placeholder="{{ __('Device IMEI/SN') }}" />
            <x-ts-input wire:model="model" label="{{ __('Model') }} *" placeholder="{{ __('Device Model') }}" />
        </div>
        <x-slot::footer>
            <div class="flex items-center justify-end gap-2">
                <x-ts-button color="red" flat sm wire:click="$set('newdevice', false)">
                    {{ __('Cancel') }}
                </x-ts-button>
                <x-ts-button wire:click="addDevice" color="green" sm>
                    {{ __('Add Device') }}
                </x-ts-button>
            </div>
        </x-slot::footer>
    </x-ts-modal>
</div>
