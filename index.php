<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="header">
        <b style="letter-spacing: 2px;">LET'S CHAT</b>
        <button onclick="clearChat()" class="btn-clear">CLEAR</button>
    </div>
    <div id="box"></div>
    <div class="input-box">
        <input type="text" id="u" placeholder="User" style="width: 70px;">
        <input type="text" id="m" placeholder="Type..." style="flex: 1;">
        <button onclick="send()" class="btn-send">SEND</button>
    </div>
</div>

<script>
    function load() {
        fetch('chat_handler.php?action=fetch')
            .then(r => r.text())
            .then(html => { 
                const box = document.getElementById('box');
                box.innerHTML = html; 
                box.scrollTop = box.scrollHeight;
            });
    }

    function send() {
        let u = document.getElementById('u').value;
        let m = document.getElementById('m').value;
        if(!m) return;
        
        let formData = new FormData();
        formData.append('username', u || 'Guest');
        formData.append('message', m);

        fetch('chat_handler.php?action=send', { method: 'POST', body: formData })
            .then(() => { 
                document.getElementById('m').value = ''; 
                load(); 
            });
    }

    function clearChat() {
    if(confirm("Delete all messages and clear username?")) {
        fetch('chat_handler.php?action=clear').then(() => {
            // 1. Refresh the chat box
            load(); 
            // 2. Clear the username input field
            document.getElementById('u').value = ''; 
            // 3. Clear the message input field
            document.getElementById('m').value = ''; 
        });
    }
}

    // Auto-refresh every 2 seconds
    setInterval(load, 2000);
    load();
</script>

</body>
</html>