<div class="bg-zinc-800 rounded-md w-full md:max-w-lg p-6 space-y-4 border border-zinc-700 md:mx-auto">

    <h1 class="text-center text-xl font-bold text-slate-100">RECHARGE</h1>

    <div class="flex bg-zinc-700 rounded-xl overflow-hidden">
        <button wire:click="set('tab', 'moncash')"
            :class="$wire.tab === 'moncash' ? 'bg-blue-600 text-white' : 'text-zinc-400'"
            class="flex-1 py-2 text-sm font-medium">Moncash</button>
        <button wire:click="set('tab', 'natcash')"
            :class="$wire.tab === 'natcash' ? 'bg-blue-600 text-white' : 'text-zinc-400'"
            class="flex-1 py-2 text-sm font-medium">Natcash</button>
    </div>

    <div class="text-sm text-zinc-300 space-y-3">
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <p>
                    <strong>Number:</strong> {{ $this->paymentMethod['account_number'] }}
                </p>
                <x-ts-clipboard icon :text="$this->paymentMethod['account_number']" />

            </div>
        </div>
        <div class="flex justify-between items-center">
            <p><strong>Name:</strong> {{ $this->paymentMethod['holder_name'] }}</p>
            <a href="{{ route('recharge-guide') }}" class="text-primary-500 text-xs hover:underline">Guide</a>
        </div>
    </div>

    <div>
        <x-ts-input wire:model="sender_fullname" label="Fullname *" placeholder="" />
    </div>

    <div>
        <x-ts-input wire:model="transcode" label="Transaction ID ou Transcode *" placeholder="1234567890" />
    </div>

    <div>
        <x-ts-input wire:model="amount" icon="currency-dollar" label="Amount *" placeholder="100" type="number" />
    </div>

    <div>
        <x-ts-input wire:model="sender_number" prefix="+509" icon="phone" position="right"
            label="Sender Phone number *" placeholder="43053547" />
    </div>


    <div>
        <x-ts-upload class="mx-auto h-48" wire:model="screenshot" label="Transaction screenshot"
            hint="We need the transaction screenshot to analyze your submission"
            tip="Drag and drop your screenshot here" />
    </div>


    <x-ts-button class="w-full" wire:click="submitRequest" size="lg">Submit Recharge Request</x-ts-button>
</div>
