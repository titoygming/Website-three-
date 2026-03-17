<?php

namespace App\Livewire;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Transactions extends Component
{

    use WithPagination;
    public mixed $search = '';
    public mixed $quantity = 5;

    #[Computed()]
    public function transactions(): LengthAwarePaginator
    {
        return user()->transactions()
            ->orderByDesc('created_at')
            ->paginate();
    }

    #[Title("Transactions")]
    public function render(): View
    {
        return view('livewire.transactions');
    }
}
