<?php

namespace App\Livewire;

use App\Events\OrderPlaced;
use App\Models\Device;
use App\Models\Order;
use App\Models\Service;
use App\Services\OrderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

class Orders extends Component
{

    use WithPagination, Interactions;

    public string $search = '';
    public ?int $quantity = 5;

    public ?string $serviceId = null;
    public ?string $deviceId = null;
    public bool $takeorder = false;


    #[Computed()]
    public function orders(): LengthAwarePaginator
    {
        return user()->orders()
            ->when($search = $this->search, function (Builder $query) use ($search) {
                return $query->whereHas('device', fn(Builder $subQuery) => $subQuery->whereLike('imei', '%' . $search . '%'));
            })
            ->orderByDesc('created_at')
            ->paginate($this->quantity);
    }

    #[Computed()]
    public function services(): array
    {
        return Service::query()->get()
            ->map(fn($service) => ['label' => $service->name, 'value' => $service->id, 'note' => $service->descriptions])
            ->toArray();
    }

    #[Computed()]
    public function devices(): array
    {
        return Device::query()->get()
            ->map(fn($device) => ['label' => $device->name, 'value' => $device->id, 'note' => $device->imei])
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
            'deviceId' => ['required', 'string', 'exists:devices,id'],
        ]);

        $device = Device::query()->find($this->deviceId);

        DB::beginTransaction();
        try {
            $order = (new OrderService)->handle($device, $this->service);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dialog()->error('Error', "Something wan't wrong. Please try again later")->send();
            return;
        }

        $this->takeorder = false;
        $this->reset([
            'deviceId',
            'serviceId'
        ]);
        broadcast(new OrderPlaced($order));
        $this->dialog()->success('Sucess', 'Your order has been placed')->send();
    }


    #[Title("My orders")]
    public function render(): View
    {
        return view('livewire.orders');
    }
}
