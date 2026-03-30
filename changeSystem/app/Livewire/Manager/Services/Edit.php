<?php

namespace App\Livewire\Manager\Services;

use App\Models\Service;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use TallStackUi\Traits\Interactions;

#[Layout('layouts.manager')]
class Edit extends Component
{
    use WithFileUploads, Interactions;
    public ?Service $service = null;

    public $image;
    public string $name = '';
    public int $price;
    public ?string $details = null;

    public function mount(Service $service)
    {
        $this->service = $service;
        $this->name = $service->name;
        $this->price = $service->price;
        $this->details = $service->description;
    }

    public function edit(): void
    {
        $filled = array_diff([
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->details
        ], [
            'name' => $this->service->name,
            'price' => (int)$this->service->price,
            'description' => $this->service->description
        ]);

        if (empty($filled) && !$this->image) {
            $this->dialog()->info('No Changes', 'No changes were made to the service.')->send();
            return;
        }

        $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:services,name,' . $this->service->id],
            'price' => ['required', 'numeric', 'min:1', 'max:50000'],
            'details' => ['nullable', 'string', 'min:3', 'max:1000'],
            'image' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png']
        ]);

        try {
            if ($this->image) {
                $image = $this->image->store('services', 'public');
                $this->service->update([
                    'image_url' => $image
                ]);
            }

            $this->service->update($filled);
        } catch (\Throwable $th) {
            //throw $th;
            $this->dialog()->error('Error', 'An error occurred while updating the service. Please try again.');
            return;
        }

        $this->dialog()->success('Success', 'Service updated successfully.')->flash()->send();
        $this->redirectRoute('manager.services.home', navigate: true);
    }

    #[Title('Edit Service')]
    public function render(): View
    {
        return view('livewire.manager.services.edit');
    }
}
