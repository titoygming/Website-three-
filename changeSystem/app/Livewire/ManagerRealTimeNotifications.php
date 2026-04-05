<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class ManagerRealTimeNotifications extends Component
{
    use Interactions;

    #[On('echo-private:manager.notifications,OrderPlaced')]
    public function orderPlaced($data): void
    {
        $this->dialog()
            ->success('New Order Placed', "A new order has been placed by {$data['user_name']} with order ID: {$data['order_id']}")
            ->persistent()
            ->send();
    }

    #[On('echo-private:manager.notifications,RechargeRequestPlaced')]
    public function rechargeRequest($data): void
    {
        $this->dialog()
            ->success('New Recharge Request', $data['message'])
            ->persistent()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.manager-real-time-notifications');
    }
}
