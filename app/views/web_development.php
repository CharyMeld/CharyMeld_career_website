<?php include 'app/views/partials/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Detail - Web Development</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Base Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 80px; /* Prevents content from being hidden under the header */
            background: #DBDBC3;
            color: black;
        }

        /* Hero Section */
        .hero {
            background: url('/myphpproject/public/images/web-development.jpg') no-repeat center center/cover;
            min-height: 200px; /* Ensures enough space for text */
            display: flex;
            padding: 0;
            margin-top: 30;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            background: rgba(0, 0, 0, 0.6);
            padding: 15px 30px;
            border-radius: 10px;
        }

        /* Content Container */
        .container {
            width: 80%;
            max-width: 1100px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            position: relative; /* Ensures it's placed correctly */
            z-index: 2;
        }

        .container img {
            width: 100%;
            border-radius: 10px;
        }

        /* Content Styling */
        .content {
            margin-top: 20px;
            line-height: 1.8;
            font-size: 1.1rem;
            text-align: justify;
        }

        /* Back Button */
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background: #ff6600;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
            text-align: center;
        }

        .back-link:hover {
            background: #cc5200;
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero {
                min-height: 200px;
            }

            .hero h1 {
                font-size: 1.8rem;
                padding: 10px 20px;
            }

            .container {
                padding: 15px;
            }

            .content {
                font-size: 1rem;
            }

            .back-link {
                display: block;
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <header class="hero">
        <h1>Web Development</h1>
    </header>
    
    <!-- Content Section -->
    <div class="container">
        <div class="content">
            <h2>Creating Dynamic and Engaging Websites</h2>
            <p>As a critical component of our Software Development portfolio, our Web Development service focuses on creating dynamic, responsive, and engaging websites that serve as the digital face of your business. In an increasingly connected world, a strong online presence is essential, and our web solutions are designed to capture your brand identity while providing an exceptional user experience.</p>
            
            <h3>Responsive and Mobile-First Design</h3>
            <p>We build websites that adapt seamlessly to any device, ensuring a consistent and user-friendly experience whether your customers are browsing on a desktop, tablet, or smartphone.</p>
            
            <h3>User-Centric Experience</h3>
            <p>At the core of our web development process is a focus on user experience (UX). We create intuitive navigation, visually appealing layouts, and interactive elements that engage visitors and guide them toward your key calls to action.</p>
            
            <h3>SEO and Performance Optimization</h3>
            <p>We implement best practices in search engine optimization (SEO) and performance tuning, ensuring that your site loads quickly and ranks well on search engines.</p>
            
            <h3>Custom Functionality and Integration</h3>
            <p>Whether you need an e-commerce platform, CMS, or bespoke web applications, our development team integrates complex functionalities seamlessly.</p>
            
            <h3>Ongoing Maintenance and Support</h3>
            <p>We offer continuous maintenance and support services to keep your site current, secure, and aligned with the latest technological trends.</p>
        </div>

        <!-- Back to Services Button -->
        <a href="index.php?page=services" class="back-link">Back to Services</a>
    </div>
</body>
</html>
