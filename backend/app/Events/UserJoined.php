<?php

namespace App\Events;

use App\Models\Participant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserJoined implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Participant $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant->load('user');
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('rooms.' . $this->participant->room_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'participant' => [
                'id' => $this->participant->id,
                'nickname' => $this->participant->nickname,
                'user_id' => $this->participant->user_id,
            ],
        ];
    }
}
