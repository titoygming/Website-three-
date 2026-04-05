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

class RechargeRequestAccepted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $user) {}
    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->user->id,
            'message' => 'Your recharge request has been accepted. Will be proceeding with the account recharge.',
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.' . $this->user->id),
        ];
    }
}
