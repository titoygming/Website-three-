<?php

namespace App\Livewire;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

class MyDevices extends Component
{

    use WithPagination, Interactions;

    public string $search = '';
    public ?int $quantity = 5;

    public bool $newdevice = false;

    public string $name = '';
    public string $imei = '';
    public string $model = '';

    #[Computed()]
    public function devices(): LengthAwarePaginator
    {
        return user()->devices()->when($this->search, function ($query) {
            $query->whereLike('name', '%' . $this->search . '%')
                ->orWhereLike('imei', '%' . $this->search . '%');
        })
            ->latest()
            ->orderByDesc('created_at')
            ->paginate($this->quantity);
    }

    public function addDevice(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'imei' => 'required|string|min:8|max:13|unique:devices,imei',
            'model' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            user()->devices()->create([
                'name' => $this->name,
                'imei' => $this->imei,
                'model' => $this->model,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dialog()->error('Error', 'An error occurred while adding the device. Please try again.')->send();
            return;
        }

        $this->reset(['name', 'imei', 'model']);
        $this->newdevice = false;

        $this->dialog()->success('Success', 'Device added successfully.')->send();
    }

    #[Title('My Devices')]
    public function render(): View
    {
        return view('livewire.my-devices');
    }
}
