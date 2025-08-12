<!-- chat-widget.php -->
<link rel="stylesheet" href="/myphpproject/chat/chat-widget.css">
<div id="chat-icon" onclick="toggleChatBox()">💬 Chat</div>

<div id="chat-box-container">
    <div id="chat-header">Live Chat <span onclick="toggleChatBox()" style="float:right;cursor:pointer;">✖</span></div>
    <div id="chat-box"></div>
    <input type="text" id="chat-username" placeholder="Your name" value="Guest"><br>
    <textarea id="chat-message" placeholder="Type a message..."></textarea>
    <button onclick="sendMessage()">Send</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/myphpproject/chat/chat-widget.js"></script>
