<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;


    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        $this->message = $message ;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->sender_id),
            new PrivateChannel('chat.' . $this->message->reciever_id),
        ];
    }

    public function broadcastWith(){
        return [
            'sender_id' => $this->message->sender_id,
            'reciever_id' => $this->message->reciever_id,
            'message' => $this->message->message,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }



}
