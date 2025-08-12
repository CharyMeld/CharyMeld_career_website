<?php include 'app/views/partials/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <style>
        /* Reset default margin & padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #DBDBC3;
            color: #333;
        }

        /* Container */
        .container {
            width: 95%;
            margin: auto;
            padding: 20px 0;
        }

        /* Hero Section */
        .hero {
            background: url('http://localhost/myphpproject/public/images/services-bg.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 50px;
        }

        .hero h1 {
            font-size: 3rem;
            background: rgba(0, 0, 0, 0.5);
            padding: 15px 25px;
            border-radius: 10px;
        }

        /* Services Section */
        .services-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 40px;
        }

        .service-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            text-align: center;
            width: 45%;
        }

        .service-box:hover {
            transform: translateY(-5px);
        }

        .service-box img {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }

        .service-content h3 {
            font-size: 22px;
            color: #222;
            margin-top: 15px;
        }

        .service-content p {
            font-size: 16px;
            color: #555;
        }

        .read-more {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .read-more:hover {
            background: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .service-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <div class="hero">
    </div>

    <!-- Services Section -->
    <div class="container">
         <h1 style="text-align: center;">Our Services</h1>
        <div class="services-container">

            <div class="service-box">
                <img src="/myphpproject/public/images/Records_digitization_digitalization.jpg" alt="Records Digitization">
                <h3>Records Digitization and Digitalization</h3>
                <p>Convert physical records into digital assets for easy access and security.</p>
                <a href="index.php?page=Records_digitization_digitalization" class="read-more">Read More</a>
            </div>
            <div class="service-box">
                <img src="/myphpproject/public/images/web-development.jpg" alt="Web Development">
                <h3>Web Development</h3>
                <p>Build scalable, responsive websites for businesses.</p>
                <a href="index.php?page=web_development" class="read-more">Read More</a>
            </div>
            <div class="service-box">
                <img src="/myphpproject/public/images/it_support.jpg" alt="IT Support">
                <h3>IT Support</h3>
                <p>Ensure seamless business operations with our IT solutions.</p>
                <a href="index.php?page=it_support" class="read-more">Read More</a>
            </div>
            <div class="service-box">
                <img src="/myphpproject/public/images/consultancy.jpg" alt="Consultancy">
                <h3>Consultancy</h3>
                <p>Strategic consultancy services to enhance business efficiency.</p>
                <a href="index.php?page=consultancy" class="read-more">Read More</a>
            </div>
        </div>
    </div>

</body>
</html>

<?php include __DIR__ . "/footer.php"; ?>
