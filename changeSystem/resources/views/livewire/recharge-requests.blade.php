<div>
    <div class="bg-zinc-800 rounded-md w-full p-6 space-y-4">

        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-slate-100">RECHARGE REQUESTS</h1>

                <p class="text-sm text-zinc-400">You can view the status of your recharge requests here.</p>
            </div>
            <div>
                <flux:button :href="route('recharge')" size="sm">Make a recharge request</flux:button>
            </div>
        </div>
        <x-ts-table :headers="[
            ['index' => 'id', 'label' => '#'],
            ['index' => 'amount', 'label' => 'Amount'],
            ['index' => 'payment_method', 'label' => 'Payment Method'],
            ['index' => 'status', 'label' => 'Status'],
            ['index' => 'created_at', 'label' => 'Requested At'],
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
            <x-slot:empty>
                <div class="text-center py-6">
                    <flux:icon name="inbox" class="w-12 h-12 mx-auto text-zinc-500" />
                    <p class="text-sm text-zinc-400">No recharge requests found.</p>
                    <flux:button href="{{ route('recharge') }}" class="mt-4" size="sm">Make a Recharge Request
                    </flux:button>
                </div>
            </x-slot:empty>
        </x-ts-table>
    </div>
</div>
