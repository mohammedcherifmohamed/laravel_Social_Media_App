document.addEventListener('DOMContentLoaded',function(){
    Echo.channel('public-message')
        .listen('MessageSent', (e) => {
            console.log('Message received:', e);
            document.getElementById('msg-div').innerHTML += `
                <div class="flex justify-start">
                    <div  class="max-w-[75%] px-4 py-2 rounded-xl text-sm
                          bg-gray-300 text-black rounded-bl-none">
                          ${e.message}
                    </div>
                </div>

            `;
            // You can update the UI or perform other actions here
        });
});