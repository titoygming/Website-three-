<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <x-ts-stats icon="users" title="Users" footer="Total users" :number="$this->users" />
        <x-ts-stats icon="shopping-cart" title="Orders" footer="Total orders" color="amber" :number="$this->orders" />
        <x-ts-stats icon="arrow-path-rounded-square" title="Transactions" footer="Total transactions" color="green" :number="$this->transactions" />
    </div>
</div>
