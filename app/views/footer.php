<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Make sure jQuery is included before your script -->
    <link href="/myphpproject/public/css/tailwind.css" rel="stylesheet">
    <script src="/myphpproject/chat/chat-widget.js"></script>
    <style>
#chat-box, #chat-icon {
    z-index: 9999 !important;
    position: fixed !important;
}
</style>


</head>
<!-- ✅ Footer Section -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-top">

            <!-- ✅ Quick Links -->
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php?about.php">About Us</a></li>
                    <li><a href="index.php?page=services">Services</a></li>
                    <li><a href="index.php?blog.php">Blog</a></li>
                    <li><a href="index.php?contact.php">Contact</a></li>
                </ul>
            </div>

            <!-- ✅ Social Media Links -->
            <div class="footer-col">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
                    <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>

                </div>
            </div>

            <!-- ✅ Contact Info -->
            <div class="footer-col footer-col-wide">
                <h4>Contact Us</h4>
                <p><i class="bi bi-geo-alt"></i> <b>Main Office:</b> Plot 40, Rasco Close, Sasa, Ibadan, Oyo State, Nigeria.</p>
                <p><i class="bi bi-geo-alt"></i><b>Branch Office:</b> No 15, Oladiti Adebiyi Street, Ilupeju, Lagos State, Nigeria.</p>
               <p><i class="bi bi-telephone"></i> +234 814 446 6160 </p>
                <p><i class="bi bi-envelope"></i> teamodigitalsolutions1@gmail.com</p>

            </div>
        </div>

        <!-- ✅ Copyright Section -->
        <div class="footer-bottom">
            <p>© 2025 Teamo Digital Solutions. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- ✅ CSS Styling -->
<style>
    .footer {
        background-color: #8A8A7B;
        color: #fff;
        padding: 10px 0;
        font-family: Arial, sans-serif;
    }
    .footer-container {
        width: 100%;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .footer-top {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
        max-width: 1200px;
        padding-bottom: 5px;
        border-bottom: 1px solid #444;
    }
    .footer-col {
        flex: 1;
        padding: 15px;
        min-width: 200px;
    }
    .footer-col-wide {
        flex: 2;
    }
    .footer-col h4 {
        font-size: 16px;
        margin-bottom: 10px;
        color: #f4b400;
    }
    .footer-col ul {
        list-style: none;
        padding: 0;
    }
    .footer-col ul li {
        margin: 8px 0;
    }
    .footer-col ul li a {
        text-decoration: none;
        color: #ccc;
        transition: color 0.3s;
    }
    .footer-col ul li a:hover {
        color: #f4b400;
    }

    p {
    display: flex;
    align-items: center;
    font-size: 14px;
    margin: 5px 0;
    }

    p i {
    margin-right: 5px; /* Add space between icon and text */
    font-size: 18px; /* Adjust icon size */
    color: #007bff; /* Customize color */
    }

    .social-links {
    display: flex;
    flex-direction: column; /* Stack icons vertically */
    align-items: center; /* Center them horizontally */
    }

    .social-links a {
    font-size: 18px;
    color: #333; /* Adjust color if needed */
    margin: 7px 0; /* Space between icons */
    text-decoration: none;
    }

    .social-links a:hover {
    color: #007bff; /* Change to desired hover color */
    }

   
    }
    .footer-bottom {
        margin-top: 02px;
        font-size: 14px;
        color: #aaa;
    }
</style>


<!-- Chat Icon (Floating Button) -->
<div id="chat-icon" class="fixed bottom-8 right-6 bg-blue-600 text-white p-3 rounded-full cursor-pointer shadow-lg z-9999">
    💬
</div>

<!-- Chat Box -->
<div id="chat-box" class="fixed right-6 bg-white border border-gray-300 shadow-xl rounded-lg w-80 hidden z-9999">
    <div class="flex items-center justify-between bg-blue-600 text-white p-3 rounded-t-lg">
        <span>Live Chat</span>
        <button id="close-chat" class="text-white hover:text-gray-300">&times;</button>
    </div>

    <div id="chat-status" class="text-sm text-center py-1 bg-gray-100 text-gray-600"></div>

    <div id="chat-messages" class="p-3 h-64 overflow-y-auto text-sm"></div>

    <div class="p-3 border-t border-gray-300">
        <input type="hidden" id="chat-username" value="Guest" />
        <input id="chat-message" type="text" placeholder="Type your message..." class="w-full border rounded px-3 py-2 text-sm focus:outline-none" />
        <!-- File Upload -->
        <input type="file" id="chat-file" class="mt-2 w-full text-sm" />
        <button id="send-btn" class="mt-2 w-full bg-blue-600 text-white rounded py-2 hover:bg-blue-700 transition">Send</button>
    </div>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function fetchMessages() {
    fetch('/myphpproject/chat/fetch_messages.php')
        .then(res => res.json())
        .then(data => {
            const chatBox = document.getElementById('chat-messages');
            chatBox.innerHTML = ''; // Clear current messages
            data.reverse(); // Reverse the array to show oldest messages first, newest at the bottom
            data.forEach(msg => {
                const attachmentHtml = msg.attachment ? (msg.attachment.match(/\.(jpeg|jpg|gif|png)$/) 
                    ? `<img src="/myphpproject/${msg.attachment}" class="mt-1 max-w-full rounded shadow" />` 
                    : `<a href="/myphpproject/${msg.attachment}" target="_blank" class="block mt-1 text-blue-600 underline">Download File</a>`) : '';

                chatBox.innerHTML += `
                    <div class="mb-2 flex items-start gap-2">
                        <img src="/myphpproject/avatars/${msg.avatar}" class="w-8 h-8 rounded-full" />
                        <div>
                            <div><strong>${msg.user}</strong> <span class="text-xs bg-gray-200 rounded px-1">${msg.role}</span></div>
                            <div>${msg.message}</div>
                            ${attachmentHtml}
                            <div class="text-xs text-gray-500">${msg.timestamp}</div>
                        </div>
                    </div>
                `;
            });
            chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom to show latest messages
        })
        .catch(err => console.error("Message fetch error:", err));
}

function sendMessage() {
    const messageInput = document.getElementById('chat-message');
    const user = document.getElementById('chat-username').value;
    const fileInput = document.getElementById('chat-file');
    const formData = new FormData();

    formData.append("user", user);
    formData.append("message", messageInput.value);
    if (fileInput.files.length > 0) {
        formData.append("attachment", fileInput.files[0]);
    }

    fetch('/myphpproject/chat/send_message.php', {
        method: 'POST',
        body: formData
    }).then(() => {
        messageInput.value = ''; // Clear the input after sending
        fileInput.value = ''; // Clear file input
        fetchMessages(); // Re-fetch messages after sending
    });
}

function fetchAdminStatus() {
    fetch('/myphpproject/chat/fetch_admin_status.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('chat-status').textContent =
                data.status === 'online' ? 'Admin is online' : 'Admin is offline';
        });
}

// Adjust the chat box position based on the header height
function adjustChatBoxPosition() {
    const headerHeight = document.querySelector('header') ? document.querySelector('header').offsetHeight : 0;
    const chatBox = document.getElementById('chat-box');
    chatBox.style.bottom = `${headerHeight + 10}px`; // Ensure it's not hidden under the header
}

// Toggle chat box visibility
document.getElementById('chat-icon').onclick = () => {
    document.getElementById('chat-box').classList.remove('hidden');
    adjustChatBoxPosition(); // Adjust position when chat box is opened
};

// Close chat
document.getElementById('close-chat').onclick = () => {
    document.getElementById('chat-box').classList.add('hidden');
};

// Send on button click
document.getElementById('send-btn').onclick = sendMessage;

// Send on Enter key
document.getElementById('chat-message').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        sendMessage();
    }
});

// Auto-refresh every 2 seconds for messages and 5 seconds for admin status
setInterval(fetchMessages, 2000);
setInterval(fetchAdminStatus, 5000);

// Ensure the chat box is correctly positioned on page load
document.addEventListener('DOMContentLoaded', () => {
    fetchMessages(); // Fetch messages on page load
    fetchAdminStatus(); // Fetch admin status on page load
    adjustChatBoxPosition(); // Adjust chat box position on page load
});
</script>



