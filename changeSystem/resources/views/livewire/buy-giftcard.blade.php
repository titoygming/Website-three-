<div class="px-4 py-8 md:px-8 max-w-4xl mx-auto">
    <div class="mb-8">
        <header>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-800 dark:text-zinc-100">
                {{ __('Buy Gift Card') }}
            </h2>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Select a gift card to instantly receive it in your digital wallet.') }}
            </p>
        </header>
    </div>

    <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl shadow-xs border border-zinc-200 dark:border-zinc-800">
        <form wire:submit.prevent="takeOrder" class="space-y-6">
            <div>
                <x-ts-select.styled label="Select Gift Card" :options="$this->services" wire:model.live="serviceId" searchable />
            </div>

            @if ($this->service)
                <div
                    class="space-y-2 p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <h3 class="font-bold text-zinc-800 dark:text-zinc-100">{{ $this->service->name }}</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $this->service->description }}</p>
                    <p class="text-lg font-black text-blue-600 dark:text-blue-400">Cost:
                        {{ number_format($this->service->price, 0, ',', '.') }}</p>
                </div>
            @endif

            <div class="pt-4 flex items-center justify-end">
                <x-ts-button type="submit" color="blue" sm>
                    {{ __('Complete Purchase') }}
                </x-ts-button>
            </div>
        </form>
    </div>
</div>
