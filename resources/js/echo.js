import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: false, // use true only if you configured HTTPS for Reverb
    enabledTransports: ['ws', 'wss'],
});


// console.log("hello from echo")


// let onlineUsers = [];

// window.Echo.join('chat.online')
//     .here((users) => {
//         onlineUsers = users;
//         console.log("Currently online:", onlineUsers);
//     })
//     .joining((user) => {
//         onlineUsers.push(user);
//         console.log(user.name + " joined");
//     })
//     .leaving((user) => {
//         onlineUsers = onlineUsers.filter(u => u.id !== user.id);
//         console.log(user.name + " left");
//     });