<?php

namespace App\Livewire\Manager;

use App\Models\Order;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Concerns\ErrorHandler;
use Livewire\Attributes\Title;
use App\Services\OrderService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

#[Layout('layouts.manager')]
class Orders extends Component
{

    use WithPagination, ErrorHandler;

    public ?string $search = "";
    public ?int $quantity = 5;

    #[Computed()]
    public function orders(): LengthAwarePaginator
    {
        $orders = Cache::remember(user()->id . '-orders', 30, fn() => Order::query()->orderByDesc('created_at')->paginate($this->quantity));
        return $orders;
    }

    protected function clearOrderCache(): void
    {
        Cache::forget(user()->id . '-orders');
    }


    public function acceptOrder(Order $order): void
    {
        try {
            (new OrderService)->accept($order);
        } catch (\Throwable $th) {
            $this->dialog()->error('Error', 'Something went wrong. Please try again later')->send();
            return;
        }
        $this->clearOrderCache();

        $this->dialog()->success('Order accepted successfully')->send();
    }

    public function cancelOrder(Order $order): void
    {
        try {
            (new OrderService)->cancel($order);
        } catch (\Throwable $th) {
            $this->dialog()->error('Error', 'Something went wrong. Please try again later')->send();
            return;
        }

        $this->clearOrderCache();
        $this->dialog()->success('Order canceled successfully')->send();
    }

    public function rejectOrder(Order $order): void
    {
        try {
            (new OrderService)->reject($order);
        } catch (\Throwable $th) {
            $this->dialog()->error('Error', 'Something went wrong. Please try again later')->send();
            return;
        }

        $this->clearOrderCache();
        $this->dialog()->success('Order rejected successfully')->send();
    }

    public function doneOrder(Order $order): void
    {
        try {
            (new OrderService)->done($order);
        } catch (\Throwable $th) {
            $this->dialog()->error('Error', 'Something went wrong. Please try again later')->send();
            return;
        }

        $this->clearOrderCache();
        $this->dialog()->success('Order done successfully')->send();
    }

    #[Title('Orders')]
    public function render(): View
    {
        return view('livewire.manager.orders');
    }
}
