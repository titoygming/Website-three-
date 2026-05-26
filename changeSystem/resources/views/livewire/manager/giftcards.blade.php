<div x-data='{}'>
    <x-ts-loading />
    <header class="mb-5">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">Gift Cards Management</flux:heading>
                <flux:text class="mt-2 mb-6 text-base">Manage gift cards</flux:text>
            </div>
            <div>
                <flux:button :href="route('manager.giftcards.create')" wire:navigate icon="gift" class="cursor-pointer"
                    size="sm">{{ __('Add gift card') }}</flux:button>
            </div>
        </div>
        <flux:separator variant="subtle" />
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($this->giftcards as $giftcard)
            <flux:card class="p-0 relative">
                @if ($giftcard->image_url)
                    <img class="rounded-md w-full h-48 object-cover" src="{{ storage_url($giftcard->image_url) }}"
                        alt="">
                @else
                    <div
                        class="bg-gray-300 border-2 border-dashed rounded-xl w-full h-48 flex items-center justify-center p-4">
                        <flux:text class="text-gray-500 text-center">No image available</flux:text>
                    </div>
                @endif
                <p class="absolute top-5 right-5 text-sm text-emerald-700 bg-emerald-300 font-bold p-2 rounded-md">
                    {{ $giftcard->price }}</p>
                <div class="absolute bottom-0 left-0 rounded-bl-md rounded-br-md w-full bg-black/50 p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <flux:heading level="3" size="xl" class="absolute bottom-2 left-2 p-4 text-white">
                                {{ str($giftcard->name)->upper()->limit(25) }}
                            </flux:heading>
                        </div>
                        <flux:tooltip content="Edit gift card">
                            <flux:button :href="route('manager.giftcards.edit', $giftcard->id)" wire:navigate
                                variant="ghost" icon="pencil" class="cursor-pointer text-white hover:text-gray-200">
                            </flux:button>
                        </flux:tooltip>
                    </div>
                </div>
            </flux:card>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $this->giftcards->links() }}
    </div>
</div>
