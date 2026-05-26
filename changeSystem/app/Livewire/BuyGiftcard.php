<?php

namespace App\Livewire;

use App\Enums\ServiceType;
use App\Events\OrderPlaced;
use App\Models\Service;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class BuyGiftcard extends Component
{
    use Interactions;

    #[Url('service_code')]
    public ?string $serviceId = '';

    #[Computed()]
    public function services(): array
    {
        return Service::query()->giftcard()->get()
            ->map(fn($service) => ['label' => $service->name . ' (' . number_format((float) $service->price, 0, ',', '.') . ')', 'value' => $service->id, 'note' => $service->description])
            ->toArray();
    }

    #[Computed()]
    public function service(): ?Service
    {
        return $this->serviceId ? Service::query()->find($this->serviceId) : null;
    }

    public function takeOrder(): void
    {
        $this->validate([
            'serviceId' => ['required', 'string', 'exists:services,id'],
        ]);

        $service = $this->service;

        if ($service->type !== ServiceType::Giftcard) {
            $this->dialog()->error('Error', 'You can only purchase gift cards here.')->send();

            return;
        }

        DB::beginTransaction();
        try {
            $order = (new OrderService)->handle(null, $service);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dialog()->error('Error', 'Something went wrong. Please try again later')->send();

            return;
        }

        $this->reset(['serviceId']);
        broadcast(new OrderPlaced($order));
        $this->dialog()->success('Success', 'Your gift card purchase was successful')->send();
    }

    #[Title('Buy Gift Card')]
    public function render(): View
    {
        return view('livewire.buy-giftcard');
    }
}
