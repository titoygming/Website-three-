<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class RechargeForm extends Component
{

    use WithFileUploads;

    public $screenshot;

    #[Title('Recharge')]
    public function render(): View
    {
        return view('livewire.recharge-form');
    }
}
