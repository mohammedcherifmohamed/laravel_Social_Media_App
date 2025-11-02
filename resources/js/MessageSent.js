 console.log('Message Sent script');

document.addEventListener('DOMContentLoaded', function () {
    Echo.private('chat.' + USER_ID)
        .listen('MessageSent', (e) => {
            console.log('New message received:', e);

            const align = e.sender_id === USER_ID ? 'end' : 'start';
            const bubbleClass = e.sender_id === USER_ID
                ? 'bg-blue-500 text-white rounded-br-none'
                : 'bg-gray-300 text-black rounded-bl-none';

            const msgDiv = document.getElementById('msg-div');

            // Only display message if it's relevant to the open chat
            if (
                parseInt(e.sender_id) === parseInt(CURRENT_CHAT_ID) ||
                parseInt(e.reciever_id) === parseInt(CURRENT_CHAT_ID)
            ) {
                msgDiv.innerHTML += `
                    <div class="flex justify-${align}">
                        <div class="max-w-[75%] px-4 py-2 rounded-xl text-sm ${bubbleClass}">
                            ${e.message}
                        </div>
                    </div>
                `;
                msgDiv.scrollTop = msgDiv.scrollHeight;
            }
        })

        // 👇 Typing whisper listener
        .listenForWhisper('typing', (e) => {
            if (parseInt(e.user_id) !== parseInt(USER_ID)) {
                const typingDiv = document.getElementById('typing-indicator');
                typingDiv.innerText = `${e.user_name} is typing...`;

                // Clear the indicator after 3 seconds
                clearTimeout(window.typingTimeout);
                window.typingTimeout = setTimeout(() => {
                    typingDiv.innerText = '';
                }, 3000);
            }
        });
});
