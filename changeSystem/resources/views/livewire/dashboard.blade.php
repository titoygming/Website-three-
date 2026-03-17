<div class="p-4">
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
        <x-ts-stats icon="wallet" title="Balance" :number="user()->balance" />
        <x-ts-stats icon="device-phone-mobile" color="blue" title="Devices" :number="user()->devices->count()" />
        <x-ts-stats icon="shopping-cart" color="amber" title="Orders" :number="user()->orders->count()" />
        <x-ts-stats icon="arrow-path-rounded-square" color="green" title="Transactions" :number="user()->transactions->count()" />
    </div>
</div>
