<div>
    <div class="bg-zinc-800 rounded-md w-full space-y-4">

        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-slate-100">RECHARGE REQUESTS</h1>

                <p class="text-sm text-zinc-400">View recharge requests here.</p>
            </div>
        </div>
        <x-ts-table :headers="[
            ['index' => 'id', 'label' => '#'],
            ['index' => 'user.name', 'label' => 'User name'],
            ['index' => 'amount', 'label' => 'Amount'],
            ['index' => 'payment_method', 'label' => 'Payment Method'],
            ['index' => 'status', 'label' => 'Status'],
            ['index' => 'created_at', 'label' => 'Requested At'],
            ['index' => 'actions', 'label' => 'Actions'],
        ]" :rows="$this->rechargeRequests" :quantity="[5, 10, 25, 50]" filter paginate>

            @interact('column_amount', $row)
                <span class="font-medium text-green-500">{{ number_format($row->amount, 2) }}</span>
            @endinteract

            @interact('column_status', $row)
                <span @class([
                    'px-2 py-1 rounded-full text-xs font-medium',
                    'bg-yellow-500/20 text-yellow-500' =>
                        $row->status === \App\Enums\RechargeRequestStatus::Pending,
                    'bg-green-500/20 text-green-500' =>
                        $row->status === \App\Enums\RechargeRequestStatus::Approved,
                    'bg-green-500/20 text-green-500' =>
                        $row->status === \App\Enums\RechargeRequestStatus::Done,
                    'bg-red-500/20 text-red-500' =>
                        $row->status === \App\Enums\RechargeRequestStatus::Rejected,
                ])>
                    {{ str($row->status->value)->upper() }}
                </span>
            @endinteract

            @interact('column_actions', $row)
                @if ($row->status === \App\Enums\RechargeRequestStatus::Pending)
                    <flux:tooltip content="Mark as accepted">
                        <x-ts-button.circle icon="check-badge" color="green" class="cursor-pointer"
                            wire:click="markAsAccepted('{{ $row->id }}')" flat sm></x-ts-button.circle>
                    </flux:tooltip>

                    <flux:tooltip content="Mark as rejected">
                        <x-ts-button.circle icon="x-mark" color="red" class="cursor-pointer" flat
                            sm></x-ts-button.circle>
                    </flux:tooltip>
                @elseif($row->status === \App\Enums\RechargeRequestStatus::Approved)
                    <flux:tooltip content="Recharge user account">
                        <x-ts-button.circle icon="arrow-down-circle" color="green" class="cursor-pointer"
                            wire:click="rechargeAccount('{{ $row->id }}')" flat sm></x-ts-button.circle>
                    </flux:tooltip>
                @endif

                <flux:tooltip content="View details">
                    <x-ts-button.circle icon="eye" color="blue" class="cursor-pointer" flat
                        wire:click="viewDetails('{{ $row->id }}')" sm></x-ts-button.circle>
                </flux:tooltip>
            @endinteract
            <x-slot:empty>
                <div class="text-center py-6">
                    <flux:icon name="inbox" class="w-12 h-12 mx-auto text-zinc-500" />
                    <p class="text-sm text-zinc-400">No recharge requests found.</p>
                </div>
            </x-slot:empty>
        </x-ts-table>
    </div>

    <x-ts-modal title="Recharge amount" size="md" center wire>
        <div class="w-full space-y-3">
            <x-ts-input wire:model="amount" label="Amount *" hint="Set amount to recharge user account" />
            <flux:button class="w-full" color="teal"
                wire:click="rechargeUserAccount('{{ $this->request_id ?? '' }}')">
                Recharge</flux:button>
        </div>
    </x-ts-modal>

    <x-ts-modal title="Recharge request details" size="3xl" center wire="viewDetail">
        @if ($this->request)
            <div class="w-full">

                <!-- Info grid -->
                <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-sm">

                    <div>
                        <p class="text-zinc-400">User name</p>
                        <p class="text-zinc-100 font-medium">
                            {{ $this->request?->user?->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-zinc-400">Amount</p>
                        <p class="text-blue-400 font-semibold">
                            {{ number_format($this->request?->amount, 2) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-zinc-400">Payment method</p>
                        <p class="text-zinc-200">
                            {{ $this->request?->payment_method }}
                        </p>
                    </div>

                    <div>
                        <p class="text-zinc-400">Status</p>

                        <span @class([
                            'inline-flex items-center px-2 py-1 text-xs font-medium rounded-full border',
                            'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' =>
                                $this->request->status === \App\Enums\RechargeRequestStatus::Pending,
                        
                            'bg-blue-500/10 text-blue-400 border-blue-500/20' =>
                                $this->request->status === \App\Enums\RechargeRequestStatus::Approved,
                        
                            'bg-green-500/10 text-green-400 border-green-500/20' =>
                                $this->request->status === \App\Enums\RechargeRequestStatus::Done,
                        
                            'bg-red-500/10 text-red-400 border-red-500/20' =>
                                $this->request->status === \App\Enums\RechargeRequestStatus::Rejected,
                        ])>
                            {{ str($this->request?->status->value)->upper() }}
                        </span>
                    </div>

                    <div>
                        <p class="text-zinc-400">Requested at</p>
                        <p class="text-zinc-300">
                            {{ $this->request?->created_at?->format('d M Y, h:i A') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-zinc-400">Approved at</p>
                        <p class="text-zinc-300">
                            {{ $this->request?->approved_at?->format('d M Y, h:i A') ?? '—' }}
                        </p>
                    </div>

                    <div class="col-span-2">
                        <p class="text-zinc-400">Approved by</p>
                        <p class="text-zinc-200">
                            {{ $this->request?->approver?->name ?? '—' }}
                        </p>
                    </div>

                </div>

                <!-- Screenshot -->
                <div class="mt-6">
                    <p class="text-zinc-400 text-sm mb-2">Payment screenshot</p>

                    <div class="relative group rounded-xl overflow-hidden border border-zinc-800 bg-zinc-800">
                        <img src="{{ storage_url($this->request?->screenshot_path) }}"
                            class="w-full object-cover transition duration-300 group-hover:scale-105 cursor-zoom-in">

                        <!-- Overlay hover -->
                        <div
                            class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition flex items-center justify-center">
                            <span
                                class="opacity-0 group-hover:opacity-100 text-xs text-white bg-black/60 px-3 py-1 rounded-md">
                                Click to zoom
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        @endif

        <x-slot:footer>
            <flux:button variant="danger" wire:click="$set('viewDetail', false)" size="sm">Close</flux:button>
        </x-slot:footer>
    </x-ts-modal>
</div>
