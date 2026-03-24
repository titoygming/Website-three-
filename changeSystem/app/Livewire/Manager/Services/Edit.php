<?php

namespace App\Livewire\Manager\Services;

use App\Models\Service;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Layout('layouts.manager')]
class Edit extends Component
{
    public ?Service $service = null;

    public function mount(Service $service)
    {
        $this->service = $service;
    }

    #[Title('Edit Service')]
    public function render(): View
    {
        return view('livewire.manager.services.edit');
    }
}
