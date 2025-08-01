
// toggleChatBox(this)

window.hidechatBox= function(){
    document.querySelector('.chat-box').classList.add('hidden');
}

window.openChat = function (id) {
        CURRENT_CHAT_ID = id;
    const chatBox = document.querySelector('#chat-box');
    chatBox.classList.remove('hidden');
    
    fetch('/home/chatWith/'+id ,{
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => res.json())
    .then(data => {
        console.log('Conversation data:', data);
        const msgDiv = document.getElementById('msg-div');
        const chat_receiver = document.getElementById('chat-receiver');

        const reciever_id = document.getElementById('reciever_id');
        reciever_id.value = data.reciever_id;

        chat_receiver.innerHTML = "Chat With " + data.reciever_chat;
        msgDiv.innerHTML = ''; // Clear previous messages
        data.chat_messages.forEach(message => {
            msgDiv.innerHTML += `
                <div class="flex justify-${message.sender_id === data.current_user ? 'end' : 'start'}">
                    <div class="max-w-[75%] px-4 py-2 rounded-xl text-sm
                          ${message.sender_id === data.current_user ? 'bg-blue-500 text-white rounded-br-none' : 'bg-gray-300 text-black rounded-bl-none'}">
                          ${message.message}
                    </div>
                </div>
            `;
        });
        msgDiv.scrollTop = msgDiv.scrollHeight;
    })
    .catch(err => {
        console.error('Error fetching conversation:', err);
    })
    
    console.log(id);

}

window.sendMessage = function(event){
    event.preventDefault();

    const form = event.target;
    const message = form.message.value;
    const reciever_id = form.reciever_id.value;

    fetch('/home/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            message: message,
            reciever_id: reciever_id
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log('Message sent:', data);
        form.message.value = ''; // Clear input
    })
    .catch(err => {
        console.error('Failed to send message:', err);
    });
}
