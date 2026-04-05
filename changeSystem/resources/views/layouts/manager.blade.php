<x-layouts::app.sidebar :title="$title ?? null">
    <livewire:manager-real-time-notifications />
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
