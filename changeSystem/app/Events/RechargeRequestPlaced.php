<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RechargeRequestPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $user) {}

    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->user->id,
            'message' => 'A new recharge request has been placed. Please review and process the request as soon as possible.',
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('manager.notifications'),
        ];
    }
}
