<?php

namespace App\Events;

use App\Models\Participant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswerSubmitted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Participant $participant;
    public bool $isCorrect;
    public int $score;

    public function __construct(Participant $participant, bool $isCorrect, int $score)
    {
        $this->participant = $participant;
        $this->isCorrect = $isCorrect;
        $this->score = $score;
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
            'participant_id' => $this->participant->id,
            'nickname' => $this->participant->nickname,
            'is_correct' => $this->isCorrect,
            'score' => $this->score,
        ];
    }
}


