<?php include 'app/views/partials/header.php'; ?>
<div class="clients-section">
    <h2>Our Trusted Clients</h2>
    
    <!-- Clients Container -->
    <div class="clients-container">
        <?php
        // Fetch all clients
        $stmt = $pdo->query("SELECT * FROM clients");
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($clients as $client) {
            echo "<div class='client'>
                    <img src='uploads/" . htmlspecialchars($client['logo']) . "' alt='" . htmlspecialchars($client['name']) . "'>
                    <h3>" . htmlspecialchars($client['name']) . "</h3>
                    <p>" . htmlspecialchars($client['description']) . "</p>
                    <a href='" . htmlspecialchars($client['website']) . "' target='_blank'>Visit Website</a>
                  </div>";
        }
        ?>
    </div>
</div>

<!-- Testimonials Section -->
<div class="testimonials-section">
    <h2 style="text-align: center; font-size: 34px">Testimonials</h2>
    <div class="testimonials-container">
        <?php
        // Fetch all testimonials
        $stmt = $pdo->query("SELECT * FROM testimonials");
        $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($testimonials as $testimonial) {
            echo "<div class='testimonial'>
                    <p>\"" . htmlspecialchars($testimonial['testimonial_text']) . "\"</p>
                    <p>- <strong>" . htmlspecialchars($testimonial['author_name']) . "</strong></p>
                </div>";
        }
        ?>
    </div>
</div>


<style>
   
  /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f5f5f5;
    margin-top: 100px;
    padding: 0;
    color: #333;
}

/* Container for the whole section */
.clients-section {
    padding: 60px 20px;
    background-color: #ffffff;
    text-align: center;
}

/* Section Title */
.clients-section h2 {
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 40px;
    color: #2c3e50;
}

/* Flex container for client cards */
.clients-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Ensure 4 clients per row */
    gap: 40px;
    margin-top: 20px;
    justify-items: center; /* Centers items inside the grid */
}

/* Client Card Styles */
.client {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 30px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    width: 100%; /* Ensure client card takes full available space */
    max-width: 300px; /* Fixed max width */
    box-sizing: border-box;
    margin-bottom: 30px;
    height: auto;
}

/* Hover Effect for Cards */
.client:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

/* Client Logo */
.client img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
}

/* Client Name */
.client h3 {
    font-size: 1.8rem;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 10px;
}

/* Client Description */
.client p {
    font-size: 1rem;
    color: #7f8c8d;
    margin-bottom: 20px;
    height: 100px; /* Set a fixed height to avoid overflowing */
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%; /* Ensures the description width is limited to the card's width */
}

/* Visit Website Button */
.client a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

/* Hover effect for the visit website button */
.client a:hover {
    background-color: #2980b9;
}

/* Testimonial Section */
.testimonials-section {
    margin-top: 50px;
    padding: 40px 20px;
    background-color: #f7f7f7;
}

.testimonial {
    font-style: italic;
    color: #2c3e50;
    font-size: 1.2rem;
    margin-top: 20px;
}

.testimonial strong {
    font-weight: bold;
    color: #3498db;
}

/* Testimonials Grid */
.testimonials-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Ensure 4 testimonials per row */
    gap: 20px;
    justify-items: center;
}

/* Mobile Responsive Adjustments */
@media (max-width: 768px) {
    .clients-section {
        padding: 40px 15px;
    }

    /* Clients container layout for mobile */
    .clients-container {
        grid-template-columns: 1fr 1fr; /* 2 clients per row on mobile */
    }

    .client {
        width: 80%; /* Allow client cards to take more space */
        margin: 10px 0;
    }

    /* Adjusting the text size for smaller screens */
    .clients-section h2 {
        font-size: 2rem;
    }

    /* Adjust the text description size for mobile */
    .client p {
        font-size: 0.9rem;
    }

    /* Testimonials Grid for mobile (1 per row on small screens) */
    .testimonials-container {
        grid-template-columns: 1fr; /* Stack testimonials vertically on mobile */
    }
}


</style>