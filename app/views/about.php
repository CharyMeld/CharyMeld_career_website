<?php include 'app/views/partials/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="styles.css">
</head>


<style>
    /* General Styles */
body {
    font-family: 'Inter', sans-serif;
    background-color: #f9fafb;
    color: #333;
    margin: 0;
    padding-top: 80px; /* Adjusted for header */
}
 .hero {
            background: url('/myphpproject/public/images/services-bg.jpg') no-repeat center center/cover;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            z-index: 2;
            margin-top: 50px; /* Creates space below header */
        }
.container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
}


/* Section Styles */
.section-title {
    color: #2563eb;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 15px;
}

.section-text {
    font-size: 18px;
    line-height: 1.8;
    color: #555;
}

/* Grid Layout */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    align-items: center;
}

.responsive-img {
    width: 75%;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

.responsive-img:hover {
    transform: scale(1.05);
}

/* Alternate Section */
.section-alt {
    background-color: #eef2ff;
    padding: 50px 20px;
    text-align: center;
}

/* Team Section */
.team-grid {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 30px;
}

.team-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 260px;
    text-align: center;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.team-card img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 3px solid #2563eb;
    margin-bottom: 10px;
}

.team-card h3 {
    font-size: 20px;
    margin: 10px 0 5px;
    font-weight: 600;
}

.team-card p {
    font-size: 16px;
    color: #666;
}

</style>
<body class="bg-gray-50 text-gray-900 pt-24">
    <!-- Hero Section -->
    <header class="hero">
        <h1>About Us</h1>
    </header>
    <!-- Who We Are Section -->
    <section class="container">
        <div class="content-grid">
            <div>
                <h2 class="section-title">Who We Are</h2>
                <p class="section-text">
                    We are a forward-thinking organization committed to delivering exceptional solutions through innovation and expertise. Our team is dedicated to making a meaningful impact in the industry by continuously improving and evolving.
                </p>
            </div>
            <div>
                <img src="/myphpproject/public/images/image3.jpg" alt="Our Team" class="responsive-img">
            </div>
        </div>
    </section>

    <!-- Our Mission Section -->
    <section class="section-alt">
        <div class="container text-center">
            <h2 class="section-title">Our Mission</h2>
            <p class="section-text max-w-3xl mx-auto">
                Our mission is to drive growth and transformation by harnessing the power of technology, collaboration, and a customer-centric approach. We strive to create value through sustainable and innovative solutions.
            </p>
        </div>
    </section>

    <!-- Meet Our Team Section -->
    <section class="container text-center">
        <h2 class="section-title">Meet Our Team</h2>
        <div class="team-grid">
            <!-- Team Members -->
            <div class="team-card">
                <img src="https://source.unsplash.com/200x200/?person,portrait" alt="John Doe">
                <h3>John Doe</h3>
                <p>CEO & Founder</p>
            </div>
            <div class="team-card">
                <img src="https://source.unsplash.com/200x200/?business,man" alt="Jane Smith">
                <h3>Jane Smith</h3>
                <p>Head of Operations</p>
            </div>
            <div class="team-card">
                <img src="https://source.unsplash.com/200x200/?woman,leader" alt="Emily Johnson">
                <h3>Emily Johnson</h3>
                <p>Marketing Director</p>
            </div>
        </div>
    </section>
<?php include __DIR__ . "/footer.php"; ?>
</body>
</html>
