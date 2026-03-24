<?php

namespace App\Livewire\Manager;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;



#[Layout('layouts.manager')]
class Transactions extends Component
{

    public ?string $search = '';
    public ?int $quantity = 5;

    #[Computed()]
    public function transactions(): LengthAwarePaginator
    {
        return Transaction::query()
            ->paginate($this->quantity);
    }

    #[Title('Transactions')]
    public function render(): View
    {
        return view('livewire.manager.transactions');
    }
}
