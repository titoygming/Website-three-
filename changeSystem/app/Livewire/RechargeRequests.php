<?php

namespace App\Livewire;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

class RechargeRequests extends Component
{
    public string $search = "";
    public ?int $quantity = 5;

    #[Computed()]
    public function rechargeRequests(): LengthAwarePaginator
    {
        return user()->rechargeRequests()->when($this->search, function ($query) {
            $query->where('amount', 'like', "%{$this->search}%")
                ->orWhere('payment_method', 'like', "%{$this->search}%");
        })->latest()->paginate($this->quantity ?? 5);
    }

    #[Title('Recharge Requests')]
    public function render(): View
    {
        return view('livewire.recharge-requests');
    }
}
