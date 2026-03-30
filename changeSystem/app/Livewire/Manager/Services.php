<?php

namespace App\Livewire\Manager;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Layout('layouts.manager')]
class Services extends Component
{
    public string $search = '';
    public ?int $quantity = 5;

    #[Computed()]
    public function services(): LengthAwarePaginator
    {
        return Service::query()
            ->orderByDesc('created_at')
            ->paginate($this->quantity);
    }


    #[Title('Our Services')]
    public function render(): View
    {
        return view('livewire.manager.services');
    }
}
