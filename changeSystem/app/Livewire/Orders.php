<?php

namespace App\Livewire;

use App\Enums\ServiceType;
use App\Events\OrderPlaced;
use App\Models\Device;
use App\Models\Service;
use App\Services\OrderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

class Orders extends Component
{
    use Interactions, WithPagination;

    public string $search = '';

    public ?int $quantity = 5;

    #[Url('service_code')]
    public ?string $serviceId = '';

    public ?string $deviceId = null;

    #[Url('take_order')]
    public bool $takeorder = false;

    #[Computed()]
    public function orders(): LengthAwarePaginator
    {
        return user()->orders()
            ->when($search = $this->search, function (Builder $query) use ($search) {
                return $query->whereHas('device', fn (Builder $subQuery) => $subQuery->whereLike('imei', '%'.$search.'%'));
            })
            ->orderByDesc('created_at')
            ->paginate($this->quantity);
    }

    #[Computed()]
    public function services(): array
    {
        return Service::query()->repair()->get()
            ->map(fn ($service) => ['label' => $service->name, 'value' => $service->id, 'note' => $service->descriptions])
            ->toArray();
    }

    #[Computed()]
    public function devices(): array
    {
        return Device::query()->get()
            ->map(fn ($device) => ['label' => $device->name, 'value' => $device->id, 'note' => $device->imei])
            ->toArray();
    }

    #[Computed()]
    public function service(): Service
    {
        return Service::query()->find($this->serviceId);
    }

    public function takeOrder(): void
    {
        $this->validate([
            'serviceId' => ['required', 'string', 'exists:services,id'],
        ]);

        $service = $this->service;

        if ($service->type === ServiceType::Repair) {
            $this->validate([
                'deviceId' => ['required', 'string', 'exists:devices,id'],
            ]);
        }

        $device = $this->deviceId ? Device::query()->find($this->deviceId) : null;

        DB::beginTransaction();
        try {
            $order = (new OrderService)->handle($device, $service);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dialog()->error('Error', 'Something went wrong. Please try again later')->send();

            return;
        }

        $this->takeorder = false;
        $this->reset([
            'deviceId',
            'serviceId',
        ]);
        broadcast(new OrderPlaced($order));
        $this->dialog()->success('Success', 'Your order has been placed')->send();
    }

    #[Title('My orders')]
    public function render(): View
    {
        return view('livewire.orders');
    }
}
