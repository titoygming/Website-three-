<?php

namespace App\Livewire\Manager;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use Livewire\Component;
use Illuminate\View\View;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;


#[Layout('layouts.manager')]
class Dashboard extends Component
{
    #[Computed()]
    public function users(): int
    {
        return User::query()->count('id');
    }

    #[Computed()]
    public function orders(): int
    {
        return Order::query()->count('id');
    }

    #[Computed()]
    public function transactions(): int
    {
        return Transaction::query()->count('id');
    }

    #[Computed()]
    public function services(): int
    {
        return Service::query()->count('id');
    }

    public function render(): View
    {
        return view('livewire.manager.dashboard');
    }
}
