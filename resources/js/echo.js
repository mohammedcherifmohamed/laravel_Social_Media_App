import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/broadcasting/auth',
  auth: {
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'X-Requested-With': 'XMLHttpRequest'
    }
  },
});

let onlineUsers = [];

window.Echo.join('chat.online')
    .here((users) => {
        onlineUsers = users;
        console.log("Currently online:", onlineUsers);
    })
    .joining((user) => {
        onlineUsers.push(user);
        console.log(user.name + " joined");
    })
    .leaving((user) => {
        onlineUsers = onlineUsers.filter(u => u.id !== user.id);
        console.log(user.name + " left");
    });