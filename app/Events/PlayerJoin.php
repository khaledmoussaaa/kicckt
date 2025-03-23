<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerJoin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public $join, public $status)
    {
        $this->join = $join;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('match.' . $this->join->match_id); // Ensure unique channel per chat
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastWith()
    {
        return match ($this->status) {
            'join' => [
                'content' => $this->join->load('user.media'),
                'success' => true,
                'message' => 'success',
                'status' => 200,
                'isJoined' => true
            ],
            'unjoin' => [
                'content' => ['id' => $this->join->id],
                'success' => true,
                'message' => 'success',
                'status' => 200,
                'isJoined' => false
            ],
        };
    }
}
