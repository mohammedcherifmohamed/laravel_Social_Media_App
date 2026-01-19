console.log("test notifications");

document.addEventListener("DOMContentLoaded", function() {
    console.log("content Loaded");

    Echo.private(`notifications.${USER_ID}`)
    .subscribed(()=> console.log(`subscribed To Notifications channel`))
    .listen("NotificationEvent", (e) => {
        console.log("NotificationEvent received:", e);
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
                <p class="text-gray-800 text-sm">${e.message}</p>
                <span class="text-xs text-gray-500">just now</span>
                <a href="/home/SeeProfile/${e.data.follower_id}">
                    <button class="text-xs text-blue-500" onclick="seeProfile(${e.data.follower_id})">See Profile</button>
                </a>

            </div>
        `;

    })
    .error((error) => {
        console.error("Error subscribing to Notifications channel:", error);
    });



    // fetch("/notifications/push",{
    //     method: "POST",
    //     headers: {
    //         "Content-Type": "application/json",
    //         "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //     },
    //     body: JSON.stringify({ user_id: USER_ID })

    // })
    // .then(res => res.json())
    // .then(data => {
    //     console.log(data);
    // })
    // .catch(err =>{
    //     console.error('Error:', err);
    // });



});

window.seeProfile =  function (id){
    console.log("see profile clicked : "+ id);
}

