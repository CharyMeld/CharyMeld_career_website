<?php include 'app/views/partials/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #DBDBC3;
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Ensures footer stays at the bottom */

/* Ensure contact section does not overlap the header */
.contact-section {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
    padding: 40px;
    background: #4FB4A8;
    max-width: 1000px;
    margin: 200px auto 50px; /* Added margin-top */
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Contact Info & Form */
.contact-info, .contact-form {
    flex: 1;
    padding: 20px;
    min-width: 300px;
}

/* Contact Form Styling */
.contact-form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;  /* Centering the form */
    width: 100%;
}
.contact-form form {
    width: 100%;
    max-width: 500px; /* Set max width for better alignment */
}
.contact-form label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}
.contact-form input, 
.contact-form textarea {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.contact-form button {
    margin-top: 15px;
    padding: 12px 20px;
    background: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}
.contact-form button:hover {
    background: #0056b3;
}


/* Map Section */
.map-container {
    text-align: center;
    max-width: 1000px;
    margin: 0 auto;
}
.map-container iframe {
    width: 100%;
    height: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Footer Styling */
footer {
    background: #222;
    color: white;
    text-align: center;
    padding: 20px;
    position: relative;
    bottom: 0;
    width: 100%;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .contact-section {
        flex-direction: column;
        text-align: center;
    }
    .contact-info, .contact-form {
        min-width: 100%;
    }
}

</style>
<body>
    
<div class="main-content"> <!-- Add this wrapper -->

    <section class="contact-section">
        <div class="contact-info">
            <h2>Contact Us</h2>
            <p>We'd love to hear from you! Reach out using the contact form or via our contact details.</p>
            <p><b>Main Office:</b> Plot 40, Rasco Close, Sasa, Ibadan, Oyo State, Nigeria.</p>
            <p><b>Branch Office:</b> No 15, Oladiti Adebiyi Street, Ilupeju, Lagos State, Nigeria.</p>
            <p><b>Phone:</b> +234 814 446 6160</p>
            <p><b>Email:</b> teamodigitalsolutions1@gmail.com</p>
        </div>
        
        <div class="contact-form">
                 <form id="contactForm" action="contactbackendscript.php" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Send Message</button>
            </form>
            <p id="formMessage"></p>
        </div>
    </section>

    <div class="map-container">
        <h3>Find Us on the Map</h3>
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.84444939761!2d3.3559001735884575!3d6.541318522958921!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8dc0a5214979%3A0x3e0706158e02a7db!2s15%20Oladiti%20Adebiyi%20St%2C%20Onipanu%2C%20Lagos%20102215%2C%20Lagos!5e0!3m2!1sen!2sng!4v1743455006580!5m2!1sen!2sng"
            width="600" height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>

</div> <!-- Close main-content wrapper -->
<script>
document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent page reload

    let formData = new FormData(this);

    fetch("/myphpproject/app/views/contactbackendscript.php", { 
    method: "POST",
    body: formData
    })

    .then(response => response.text())
    .then(data => {
        let messageBox = document.getElementById("formMessage");
        
        if (data.trim() === "success") {
            messageBox.textContent = "Message sent successfully!";
            messageBox.style.color = "green";
            document.getElementById("contactForm").reset();
        } else {
            messageBox.textContent = "Failed to send message: " + data;
            messageBox.style.color = "red";
        }
    })
    .catch(error => console.error("Fetch Error:", error));
});

</script>

<?php include __DIR__ . "/footer.php"; ?>

</body>
</html>
