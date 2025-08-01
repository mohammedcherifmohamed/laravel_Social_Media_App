<div>
    <div 
        x-data="{ open: @entangle('isChatOpen').defer }" 
        x-show="open" 
        id="chat-box" 
        class="flex flex-col h-96 bg-gray-100 rounded-lg shadow overflow-hidden w-full"
    >        
        <!-- Chat Header -->
        <div class="bg-white px-4 py-2 border-b font-bold text-lg sticky top-0 z-10">
            Chat With {{ $title }}
        </div>

        <!-- Messages Area -->
        <div  wire:poll.2s class="flex-1 overflow-y-auto px-4 py-2 space-y-2">
            @foreach($messages as $msg)
                <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[75%] px-4 py-2 rounded-xl text-sm
                        {{ $msg->sender_id == auth()->id() 
                            ? 'bg-blue-500 text-white rounded-br-none' 
                            : 'bg-gray-300 text-black rounded-bl-none' }}">
                        {{ $msg->body }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Input Form -->
        <form wire:submit.prevent="sendMessage" class="flex items-center border-t px-4 py-2 gap-2 bg-white sticky bottom-0 z-10">
            <input type="text" wire:model.defer="message" 
                   class="flex-1 border rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="اكتب رسالتك...">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-full text-sm">
                إرسال
            </button>
        </form>
    </div>
</div>
