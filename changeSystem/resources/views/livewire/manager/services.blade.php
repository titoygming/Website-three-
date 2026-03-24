<div x-data='{}'>
    <x-ts-loading />
    <header class="mb-5">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">Services Management</flux:heading>
                <flux:text class="mt-2 mb-6 text-base">Manage services</flux:text>
            </div>
            <div>
                <flux:button x-on:click="$tsui.interaction('dialog').info('Info', 'Feature in development.').send()" icon="wrench-screwdriver" class="cursor-pointer" size="sm">{{ __('Add service') }}</flux:button>
            </div>
        </div>
        <flux:separator variant="subtle" />
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($this->services as $service)
            <flux:card class="p-0 relative">
                <img class="rounded-md"
                    src="https://www.hardreset.info/media/resetinfo/2025/220/fb82187326144209a530a688975ccc9c.jpg"
                    alt="">
                <p class="absolute top-5 right-5 text-sm text-emerald-700 bg-emerald-300 font-bold p-2 rounded-md">
                    {{ $service->price }}</p>
                <div class="absolute bottom-0 left-0 rounded-bl-md rounded-br-md w-full bg-black/50 p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <flux:heading level="3" size="xl" class="absolute bottom-2 left-2 p-4">
                                {{ str($service->name)->limit(25) }}
                            </flux:heading>
                        </div>

                        <flux:tooltip content="edit service">
                            <flux:button href="/manager/services/{{ $service->id }}/edit" variant="ghost" icon="pencil" class="cursor-pointer"></flux:button>
                        </flux:tooltip>
                    </div>
                </div>
            </flux:card>
        @endforeach
    </div>
</div>
