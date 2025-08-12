<?php include 'app/views/partials/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records Digitization and Digitalization</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Smooth Background & Base Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            padding-top: 20px; /* Fixed missing semicolon */
            background: #DBDBC3;
            color: #333;
            transition: background 0.5s ease-in-out;
        }

        /* Hero Section */
        .hero {
            background: url('/myphpproject/public/images/Records_digitization_digitalization.jpg') no-repeat center center/cover;
            height: 200px; /* Increased height for better spacing */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            transition: background 0.5s ease-in-out;
        }

        .hero h1 {
            background: rgba(0, 0, 0, 0.6);
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 2rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
        }

        /* Content Container */
        .container {
            width: 75%;
            max-width: 1100px;
            margin-top: 200px;  /* Fixed incorrect margin */
            margin-left: auto;
            margin-right: auto;
            background: white;
            padding: 40px; /* Reduced padding for better spacing */
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        /* Image Styling */
        .container img {
            width: 100%;
            max-width: 200px;
            display: block;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
                height: 200px;
            }

            .hero h1 {
                font-size: 1.8rem;
                padding: 10px 20px;
            }

            .container {
                padding: 15px;
                margin-top: 30px; /* Adjusted for mobile view */
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
        <h1>Records Digitization and Digitalization</h1>
    </header>
    
    <!-- Content Section -->
    <div class="container">
        <div class="content">
            <p>In today’s fast-paced digital environment, efficient management of your physical records is essential. Our Records Digitization and Digitalization service transforms your paper documents into high-quality digital assets, ensuring enhanced accessibility, improved data security, and streamlined operations. </p>
            <p>Our service is built on a comprehensive strategy that integrates systematic organization, secure digital archiving, and the responsible disposal of obsolete records. With our solutions, businesses can transition seamlessly into a paperless environment, reducing storage costs, improving workflow efficiency, and ensuring regulatory compliance.</p>
            <p>We develop a structured system to classify and index your digital records, making retrieval quick and effortless. Our approach includes metadata frameworks, version control, and advanced search functionalities that allow instant access to critical documents. Compliance with legal and industry standards is also a top priority, with built-in access controls and audit trails ensuring data integrity.</p>
            <p>Through secure cloud-based and on-premise digital archiving, we guarantee long-term preservation of your important documents. Our solutions utilize high-level encryption and multi-layered security to protect against unauthorized access. Advanced indexing and filtering features enable efficient data retrieval, ensuring your records remain both secure and easily accessible.</p>
            <p>For records that have reached their lifecycle’s end, we provide secure document destruction through state-of-the-art shredding technologies. Our process ensures complete and irreversible data removal while adhering to environmental sustainability practices. This reduces clutter, minimizes security risks, and maintains a well-organized digital workspace.</p>
            <p>By partnering with us, businesses can eliminate inefficiencies associated with paper-based records, foster collaboration across teams, and gain peace of mind knowing their information is protected against threats and regulatory risks. Let us help you embrace the future of digital transformation with a robust Records Digitization and Digitalization strategy.</p>
        </div>

        <!-- Back to Services Button -->
         <a href="index.php?page=services" class="back-link">Back to Services</a>
    </div>
</body>
</html>
