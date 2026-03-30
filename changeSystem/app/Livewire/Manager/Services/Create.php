<?php

namespace App\Livewire\Manager\Services;

use App\Models\Service;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use TallStackUi\Traits\Interactions;

#[Layout('layouts.manager')]
class Create extends Component
{

    use WithFileUploads, Interactions;
    #[Validate(['required', 'string', 'min:3', 'max:255', 'unique:services,name'])]
    public string $name = '';

    #[Validate(['required', 'numeric', 'min:1', 'max:50000'])]
    public ?int $price = 10;

    #[Validate(['nullable', 'string', 'min:3', 'max:1000'])]
    public string $details = '';

    /**
     * @var TemporaryUploadedFile
     */
    #[Validate(['required', 'image', 'max:2048', 'mimes:jpg,jpeg,png'])]
    public $image;


    public function create(): void
    {
        $this->validate();
        try {
            $image = $this->image->store('services', 'public');
            Service::create([
                'name' => strtoupper($this->name),
                'price' => $this->price,
                'description' => $this->details,
                'image_url' => $image
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            $this->dialog()->error('Error', 'An error occurred while creating the service. Please try again.');
            return;
        }

        $this->reset(['name', 'price', 'details', 'image']);
        $this->dialog()->success('Success', 'Service created successfully.')->flash()->send();
        $this->redirectRoute('manager.services.home', navigate: true);
    }


    #[Title('Create Service')]
    public function render(): View
    {
        return view('livewire.manager.services.create');
    }
}
