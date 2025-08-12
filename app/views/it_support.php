<?php include 'app/views/partials/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Support - TeamO Digital Solutions</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Base Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Hero Section */
        .hero {
            background: url('/myphpproject/public/images/it_support.jpg') no-repeat center center/cover;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            z-index: 2;
            margin-top: 80px; /* Creates space below header */
        }

        .hero h1 {
            background: rgba(0, 0, 0, 0.6);
            padding: 15px 30px;
            border-radius: 10px;
        }

        /* Main Content */
        .container {
            width: 80%;
            max-width: 1100px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
        }

        /* Service Sections */
        .service-section {
            margin-bottom: 30px;
        }

        .service-section h2 {
            color: #007BFF;
            margin-bottom: 10px;
        }

        .service-section ul {
            padding-left: 20px;
        }

        .service-section li {
            margin-bottom: 5px;
        }

        /* Back Button */
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
            text-align: center;
        }

        .back-link:hover {
            background: #0056b3;
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

            .service-section h2 {
                font-size: 1.4rem;
            }

            .service-section p,
            .service-section ul {
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
        <h1>IT Support</h1>
    </header>
    
    <!-- Content Section -->
    <div class="container">
        <section class="service-section">
            <h2>Sales and Repairs of IT Equipment</h2>
            <p>We ensure your IT hardware operates at peak performance through expert repairs, high-quality equipment sales, and preventative maintenance programs.</p>
            <ul>
                <li>High-Quality Hardware Solutions</li>
                <li>Expert Repairs and Maintenance</li>
                <li>Preventative Maintenance Programs</li>
                <li>Tailored IT Solutions</li>
            </ul>
        </section>
        
        <section class="service-section">
            <h2>Cybersecurity Services</h2>
            <p>We provide advanced protection through firewall security, antivirus solutions, encryption protocols, and ongoing security monitoring.</p>
            <ul>
                <li>Advanced Firewall Implementation</li>
                <li>Comprehensive Antivirus Solutions</li>
                <li>Robust Encryption Protocols</li>
                <li>Ongoing Security Assessments and Monitoring</li>
            </ul>
        </section>
        
        <section class="service-section">
            <h2>Troubleshooting and System Diagnostics</h2>
            <p>Rapid IT issue resolution, system diagnostics, and preventative maintenance to ensure smooth operations and minimize downtime.</p>
            <ul>
                <li>Rapid Response and Issue Resolution</li>
                <li>Comprehensive System Diagnostics</li>
                <li>Customized Troubleshooting Procedures</li>
                <li>Preventative IT Measures</li>
            </ul>
        </section>

        <!-- Back to Services Button -->
        <a href="index.php?page=services" class="back-link">Back to Services</a>
    </div>
</body>
</html>
