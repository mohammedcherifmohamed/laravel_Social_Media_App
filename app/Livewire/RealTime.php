<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RealTime extends Component
{
    public $betamessage;
    public $message;
    public $messages = [];
    public $receiver_id;
    public $selectedUserId;
public $isChatOpen = false;

    protected $listeners = ['openChatWith' => 'setReceiver'];

    // public function mount($receiver_id = null)
    // {
    //     $this->betamessage = chat::where('reciever_id', 2)
    //         ->latest()
    //         ->value('message'); // returns just the message string
    //     $this->receiver_id = $receiver_id;
    //     $this->loadMessages();
    // }

        public function openChatWithUser($id, $name)
        {
            $this->receiver_id = $id;
            $this->title = $name;
            $this->isChatOpen = true;
            $this->loadMessages(); // your custom method
        }

     public function render($selectedUserId = null)
    {
         $this->betamessage = chat::where('reciever_id', 2)
            ->latest()
            ->value('message'); 
            $title = $selectedUserId;
        $this->selectedUserId = $selectedUserId;
        return view('livewire.real-time',compact("title"));
    }
   public $receiver_name;

    public function setReceiver($id)
    {
        dd($id);
        $this->isChatOpen = true;

        $this->receiver_id = $id;
        $this->receiver_name = \App\Models\User::find($id)?->name;
        $this->loadMessages();
    }


    public function loadMessages()
    {
        if (!$this->receiver_id) return;

        $this->messages = chat::where(function ($q) {
            $q->where('sender_id', Auth::id())
              ->where('reciever_id', $this->receiver_id);
        })->orWhere(function ($q) {
            $q->where('sender_id', $this->receiver_id)
              ->where('reciever_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:1000',
        ]);

        chat::create([
            'sender_id' => Auth::id(),
            'reciever_id' => $this->receiver_id,
            'message' => $this->message,
        ]);

        $this->message = '';
        $this->loadMessages();
    }

 
}

