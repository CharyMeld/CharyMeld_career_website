function sendMessage() {
    const messageInput = document.getElementById('chat-message');
    const message = messageInput.value.trim();
    const user = document.getElementById('chat-username').value;

    if (!message) return;

    fetch('/myphpproject/chat/send_message.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({ user, message })
    })
    .then(res => res.json())
    .then(response => {
        console.log("Send response:", response);
        if (response.success) {
            messageInput.value = '';
            fetchMessages(); // reload messages
        } else {
            alert("Message failed: " + response.error);
        }
    })
    .catch(err => {
        console.error("Send error:", err);
        alert("Something went wrong while sending the message.");
    });
}
