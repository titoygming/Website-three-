<div>
    <flux:heading size="xl" level="1">Edit service</flux:heading>
    <flux:text class="mt-2 mb-6 text-base">Edit service details</flux:text>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        <div class="preview">
            @if ($image)
                <img class="rounded-md" src="{{ $image->temporaryUrl() }}" alt="preview" class="w-full" />
            @elseif($service->image_url)
                <img class="rounded-md" src="{{ storage_url($service->image_url) }}"
                    alt="preview-{{ str($service->name)->slug() }}" class="w-full" />
            @else
                <div
                    class="bg-gray-300 border-2 border-dashed rounded-xl w-full h-96 md:h-125 flex items-center justify-center p-4">
                    <flux:text class="text-gray-500 text-center">No image available</flux:text>
                </div>
            @endif
        </div>
        <div>
            <form wire:submit="edit" class="space-y-3 relative">
                <x-ts-input label="Service name *" wire:model="name" required />
                <x-ts-input label="Price *" wire:model="price" required prefix="$" type="number" min="0"
                    step="0.01" />
                <x-ts-upload wire:model="image" label="Thumbnail *" required accept="image/*" />
                <x-ts-textarea label="Details" wire:model="details" maxlength="1000" count rows="8" />
                <flux:button type="submit" icon="arrow-path-rounded-square" class="w-full">{{ __('update service') }}
                </flux:button>
            </form>
        </div>
    </div>
</div>
