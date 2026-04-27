<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizEnded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Room $room;
    public array $leaderboard;

    public function __construct(Room $room, array $leaderboard)
    {
        $this->room = $room;
        $this->leaderboard = $leaderboard;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('rooms.' . $this->room->id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'leaderboard' => $this->leaderboard,
        ];
    }
}


