 console.log('chat script');

// toggleChatBox(this)

window.hidechatBox= function(){
    document.querySelector('.chat-box').classList.add('hidden');
}

window.openChat = function (id) {
        CURRENT_CHAT_ID = id;
    const chatBox = document.querySelector('#chat-box');
    chatBox.classList.remove('hidden');
    const modal = document.getElementById("notificationsModal");
    if(modal){
        modal.classList.add("hidden");

    }

    fetch('/home/chatWith/'+id ,{
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => res.json())
    .then(data => {
        // console.log('Conversation data:', data);
        const msgDiv = document.getElementById('msg-div');
        const chat_receiver = document.getElementById('chat-receiver');

        const typer  = document.getElementById('typing-indicator');
        typer.innerHTML = ` ${data.reciever_chat} is typing...`;

        const reciever_id = document.getElementById('reciever_id');
        reciever_id.value = data.reciever_id;

        chat_receiver.innerHTML = "Chat With " + data.reciever_chat;
        msgDiv.innerHTML = ''; 
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
                const msgDiv = document.getElementById('msg-div');

         msgDiv.innerHTML += `
                <div class="flex justify-end">
                    <div class="max-w-[75%] px-4 py-2 rounded-xl text-sm
                          bg-blue-500 text-white rounded-br-none">
                          ${form.message.value}
                    </div>
                </div>
            `;
        // add scroll 
        msgDiv.scrollTop = msgDiv.scrollHeight;
        form.message.value = '';
    })
    .catch(err => {
        console.error('Failed to send message:', err);
    });
}

window.Echo.private(`chat.${USER_ID}`)
.subscribed(()=> console.log(`subscribed user -${USER_ID}`))
.error((err)=>console.log(err))
        .listen("MessageSent",(e)=>{
                // console.log("____"+e.sender_name);
                const msgDiv = document.getElementById('msg-div');
                msgDiv.innerHTML += `
                <div class="flex justify-start">
                    <div class="max-w-[75%] px-4 py-2 rounded-xl text-sm
                           bg-gray-300 text-black rounded-bl-none ">
                          ${e.message}
                    </div>
                </div>
            `;
            msgDiv.scrollTop = msgDiv.scrollHeight;
            // parse receiver id

            const senderId = parseInt(e.sender_id);
            console.log(typeof senderId + " -- " + senderId); 
            updateNotification(senderId,e.sender_name,e.created_at);
              
})
.listenForWhisper("typing",(e)=>{
    const typing_indicator = document.getElementById('typing-indicator');
    if(typing_indicator){

        typing_indicator.classList.remove('hidden');
        setTimeout(()=>{
            typing_indicator.classList.add('hidden');
        }, 1500);

    }
});
let onlineUsers = [];
window.Echo.join('presence.online')
.here((users)=>{
    // console.log("Onlie Users : __" + users.length);
    onlineUsers = users;
    updateOnlineStatus();
})
.joining((user)=>{
    // console.log(user.name + " joined.");
    onlineUsers.push(user);
    updateOnlineStatus();
})
.leaving((user)=>{
    console.log(user.name + " left."+user.id);
    onlineUsers = onlineUsers.filter(u => u.id !== user.id);
    // console.log(onlineUsers.length + " users online now.");
    updateOnlineStatus();
})
function updateNotification(senderId,senderName,time){

     const notification_icon = document.getElementById('notification_icon');
     const notificationsList = document.getElementById('notificationsList');
        let notificationsNbr = notificationsList.children.length;

        if(notification_icon){
            notification_icon.classList.remove('hidden');
            notificationsNbr++ ;
            notification_icon.innerText = notificationsNbr;
        } 

        
        notificationsList.innerHTML +=`
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                <p class="text-gray-800 text-sm">${senderName} sent you a message</p>
                <span class="text-xs text-gray-500">${time}</span>
                <button class="text-xs text-blue-500" onclick="openChat(${senderId})">See message</button>
            </div>
        `;



}

function updateOnlineStatus(){
    
    // update status for online users
    const online_users_spans  = document.querySelectorAll('.online_users');
    online_users_spans.forEach(el => el.classList.add('hidden'));
    // console.log("Total online users elements: " + online_users_spans.length);
    online_users_spans.forEach(element => {
        const online_user_id = element.getAttribute("data-user-id");
        // console.log("Total online users in global array: " + onlineUsers.length);
        onlineUsers.forEach(user => {
            // console.log(user.id + " == " + online_user_id);
            if(user.id == online_user_id){
                element.classList.remove('hidden');
            }
        });
        // console.log("Checking online status for user id: " + online_user_id);
    });
}

window.seeNotifications = function() {

    const modal = document.getElementById("notificationsModal");
    const sidebar = document.getElementById("notificationsSidebar");
    const notification_icon = document.getElementById('notification_icon');
    notification_icon.innerHTML = "0" ;
    notification_icon.classList.add("hidden");

    modal.classList.remove("hidden");

    setTimeout(() => {
        sidebar.classList.remove("translate-x-full");
    }, 10);

}

window.closeNotifications = function() {

    const modal = document.getElementById("notificationsModal");
    const sidebar = document.getElementById("notificationsSidebar");
    sidebar.classList.add("translate-x-full");
    setTimeout(() => {
        modal.classList.add("hidden");
    }, 300);
}

document.addEventListener('DOMContentLoaded', function () {
    const chatInput = document.getElementById('chatInput');

    if(chatInput){

        chatInput.addEventListener("input",()=>{
            const reciever_id = document.getElementById('reciever_id');
            console.log("typing... " + reciever_id.value);
            window.Echo.private(`chat.${reciever_id.value}`)
            .whisper("typing",{
                userId: USER_ID ,
                name: '{{ auth()->user()->name }}',
            });
        });
    
    }

});