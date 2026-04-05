<?php

namespace App\Livewire\Manager;

use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

class Configurations extends Component
{
    #[Title('Configurations')]
    public function render(): View
    {
        return view('livewire.manager.configurations');
    }
}
