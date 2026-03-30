<div x-data='{}'>
    <x-ts-loading />
    <header class="mb-5">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">Services Management</flux:heading>
                <flux:text class="mt-2 mb-6 text-base">Manage services</flux:text>
            </div>
            <div>
                <flux:button :href="route('manager.services.create')" wire:navigate icon="wrench-screwdriver"
                    class="cursor-pointer" size="sm">{{ __('Add service') }}</flux:button>
            </div>
        </div>
        <flux:separator variant="subtle" />
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($this->services as $service)
            <flux:card class="p-0 relative">
                @if ($service->image_url)
                    <img class="rounded-md" src="{{ storage_url($service->image_url) }}" alt="">
                @else
                    <div
                        class="bg-gray-300 border-2 border-dashed rounded-xl w-full h-76 flex items-center justify-center p-4">
                        <flux:text class="text-gray-500 text-center">No image available</flux:text>
                    </div>
                @endif
                <p class="absolute top-5 right-5 text-sm text-emerald-700 bg-emerald-300 font-bold p-2 rounded-md">
                    {{ $service->price }}</p>
                <div class="absolute bottom-0 left-0 rounded-bl-md rounded-br-md w-full bg-black/50 p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <flux:heading level="3" size="xl" class="absolute bottom-2 left-2 p-4">
                                {{ str($service->name)->upper()->limit(25) }}
                            </flux:heading>
                        </div>

                        <flux:tooltip content="edit service">
                            <flux:button :href="route('manager.services.edit', $service->id)" wire:navigate
                                variant="ghost" icon="pencil" class="cursor-pointer"></flux:button>
                        </flux:tooltip>
                    </div>
                </div>
            </flux:card>
        @endforeach
    </div>
</div>
