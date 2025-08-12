function sendMessage() {
    var user = $('#username').val().trim();
    var message = $('#message').val().trim();

    if (message === '') return;

    $.post('send_message.php', { user: user, message: message }, function () {
        $('#message').val('');
        fetchMessages();
    });
}

function fetchMessages() {
    $.get('fetch_messages.php', function (data) {
        const messages = JSON.parse(data);
        let html = '';

        messages.forEach(function (msg) {
            html += `
                <div class="message">
                    <img src="${msg.avatar}" class="avatar"> 
                    <strong>${msg.user}</strong>: ${msg.message}<br>
                    <small>${msg.timestamp}</small>
                </div>
            `;
        });

        $('#chat-box').html(html);
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
    });
}

setInterval(fetchMessages, 2000);
$(document).ready(fetchMessages);
