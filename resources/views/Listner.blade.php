<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>listner</title>
</head>
<body>
    
<h1>Listner view</h1>

<script>

document.addEventListener('DOMContentLoaded',()=>{
    Echo.channel("public-test").listen('SendMsg',(event)=>{
        console.log("Event Lisnted : "+event);
    })
});

</script>

<script src="echo.js" ></script>

</body>
</html>