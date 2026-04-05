<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct(public Order $order) {}

    public function broadcastWith(): array
    {
        return [
            'user_name' => $this->order->user->name,
            'order_id' => $this->order->id,
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('manager.notifications'),
        ];
    }
}
