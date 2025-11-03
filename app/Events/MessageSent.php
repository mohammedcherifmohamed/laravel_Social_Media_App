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
    public $senderName;
    public $receiverName;

    /**
     * Create a new event instance.
     */
    public function __construct($message,$senderName,$receiverName)
    {
        $this->message = $message ;
        $this->senderName = $senderName;
        $this->receiverName = $receiverName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return 
            new PrivateChannel('chat.' . $this->message->reciever_id);

    }

    public function broadcastWith(){
        return [
            'sender_id' => $this->message->sender_id,
            'reciever_id' => $this->message->reciever_id,
            'message' => $this->message->message,
            'sender_name' => $this->senderName,
            'receiver_name' => $this->receiverName,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }



}
