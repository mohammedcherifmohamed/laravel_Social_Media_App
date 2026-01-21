

  <div id="chat-container" class="fixed bottom-16 right-4 flex gap-4 z-50">
    <div 
        id="chat-box" 
        class="hidden flex flex-col h-96 bg-gray-100 rounded-lg shadow overflow-hidden w-full"
    >        
        <!-- Chat Header -->
        <div class="flex justify-between bg-white px-4 py-2 border-b font-bold text-lg sticky top-0 z-10">
            <div id="chat-receiver" >
              
            </div> 
            <button onclick="closeChat()" class="cursor-pointer text-red-800" >X</button>
        </div>
        <!-- Messages Area -->
        <div id="msg-div" class="flex-1 overflow-y-auto px-4 py-2 space-y-2">
                
        </div>

        <!-- Input Form -->
        <div id="typing-indicator" class="text-sm text-gray-500 mt-2 ml-2 hidden"></div>

        <form onsubmit="sendMessage(event)" class="flex items-center border-t px-4 py-2 gap-2 bg-white sticky bottom-0 z-10">
          @csrf  
          <input type="text" name="reciever_id" id="reciever_id" class="hidden" >  
          <input 
                id="chatInput"
                  name="message"
                  type="text"  
                   class="flex-1 border rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="اكتب رسالتك...">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-full text-sm">
                إرسال
            </button>
        </form>
    </div>


</div>