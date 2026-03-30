<div>

    <flux:heading size="xl" level="1">Create service</flux:heading>
    <flux:text class="mt-2 mb-6 text-base">Create a new service</flux:text>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        <div class="preview">
            @if ($image)
                <img class="rounded-md" src="{{ $image->temporaryUrl() }}" alt="preview" class="w-full" />
            @else
                <div class="w-full h-96 md:h-125 rounded-md bg-gray-200 flex items-center justify-center">
                    <flux:text class="text-gray-500">Image preview</flux:text>
                </div>
            @endif
        </div>
        <div>
            <form wire:submit="create" class="space-y-3 relative">
                <x-ts-input label="Service name *" wire:model="name" required />
                <x-ts-input label="Price *" wire:model="price" required prefix="$" type="number" min="0"
                    step="0.01" />
                <x-ts-upload wire:model="image" label="Thumbnail *" required accept="image/*" />
                <x-ts-textarea label="Details" wire:model="details" maxlength="1000" count rows="8" />
                <flux:button type="submit" icon="plus" class="w-full">{{ __('Create service') }}</flux:button>
            </form>
        </div>
    </div>
</div>
