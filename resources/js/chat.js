
// toggleChatBox(this)

window.hidechatBox= function(){
    document.querySelector('.chat-box').classList.add('hidden');
}

window.openChat = function (id){
    // console.log(id);
    document.querySelector('#chat-box').classList.toggle('hidden');

    fetch(`home/chatWith/${id}`,{
        method : 'GET',
        headers:{
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        document.getElementById('chat-name').textContent='Chat With '+data.reciever_chat;
        const sender_message = document.getElementById('sender-message');
        const reciever_message = document.getElementById('reciever-message');
       
        sender_message.innerHTML = "";
        reciever_message.innerHTML = "";
        
        if(data.chat_messages.length == 0){
            document.getElementById('error_msg').textContent = "No Messages Yet";
        }else{
            document.getElementById('error_msg').textContent = "";
            data.chat_messages.forEach(message => {
            if(message.reciever_id == id){
                reciever_message.innerHTML +=`
                    <div class="max-w-[70%] px-4 py-2 rounded-lg bg-gray-200 text-gray-800 text-sm">
                        ${message.message}
                    </div>
                
                `;
            }else{
                 sender_message.innerHTML +=`
                    <div class="max-w-[70%] px-4 py-2 rounded-lg bg-blue-500 text-white text-sm">
                        ${message.message}
                    </div>
                
                `;
            }

    
             });
        }

    })
    .catch(err => {
        console.log(err);
    });

}