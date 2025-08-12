<?php include 'app/views/partials/header.php'; ?>
<?php
require_once "C:/myxamppTeamOProject/htdocs/myphpproject/config/database.php"; // Ensure DB connection

// Fetch blogs from the 'blog' table
$stmt = $pdo->prepare("SELECT * FROM blog");  // ✅ Corrected table name
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC); // ✅ Ensure it returns an array
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teamo Digital Solutions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <style>
    body {
      background-color: #f3f4f6;
    }

    .swiper {
      width: 100%;
      max-width: 1000px;
      margin: auto;
    }

    .swiper-wrapper {
      align-items: center;
    }

    .swiper-slide {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .swiper-slide img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .swiper-slide img:hover {
      transform: scale(1.05);
    }
  </style>
</head>
<body class="bg-gray-100">
  <section class="relative w-full mx-auto bg-[#DBDBC3] pt-32 py-16 rounded-lg shadow-lg overflow-hidden">
    <div class="container mx-auto">
      <h2 class="text-4xl font-bold text-[#2E2E2E] text-center mb-8">Explore Our Digital Solutions</h2>

      <!-- Swiper Slider -->
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">

          <!-- Slide 1 -->
          <div class="swiper-slide p-6">
            <img src="/myphpproject/public/images/digitization.jpg" alt="Digitization & Digitalization" />
            <div class="mt-4">
              <h3 class="text-2xl font-semibold text-[#3B4A6B]">Digitization & Digitalization</h3>
              <p class="text-[#65737E] mt-2 max-w-2xl mx-auto">
                Transforming your business operations with cutting-edge digital solutions for efficiency and innovation.
              </p>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="swiper-slide p-6">
            <img src="/myphpproject/public/images/it_consulting.jpg" alt="IT Consulting" />
            <div class="mt-4">
              <h3 class="text-2xl font-semibold text-[#3B4A6B]">IT Consulting</h3>
              <p class="text-[#65737E] mt-2 max-w-2xl mx-auto">
                Expert guidance to help you navigate the complex world of IT and implement tailored business solutions.
              </p>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="swiper-slide p-6">
            <img src="/myphpproject/public/images/web-development.jpg" alt="Software Development" />
            <div class="mt-4">
              <h3 class="text-2xl font-semibold text-[#3B4A6B]">Software Development</h3>
              <p class="text-[#65737E] mt-2 max-w-2xl mx-auto">
                Custom-built applications designed to enhance your business processes and improve customer engagement.
              </p>
            </div>
          </div>

        </div>

        <!-- Navigation Buttons -->
        <div class="swiper-button-next text-[#3B4A6B]"></div>
        <div class="swiper-button-prev text-[#3B4A6B]"></div>

        <!-- Pagination Dots -->
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>

  <!-- SwiperJS Script -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".mySwiper", {
      spaceBetween: 30,
      centeredSlides: true,
      loop: true,
      slidesPerView: 1, // 👈 Ensures only one is shown at a time
      autoplay: {
        delay: 6000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  </script>
</body>


    <!-- hero section -->
    <style >
      @keyframes wave {
    0% { transform: translateY(0); }
    50% { transform: translateY(-30px); } /* Increased height to 30px */
    100% { transform: translateY(0); }
}

.wave-text:nth-child(1) { animation: wave 3s infinite ease-in-out; }
.wave-text:nth-child(2) { animation: wave 3s infinite ease-in-out 0.2s; }
.wave-text:nth-child(3) { animation: wave 3s infinite ease-in-out 0.4s; }
.wave-text:nth-child(4) { animation: wave 3s infinite ease-in-out 0.6s; }

/* Section Styling */
.wave-section {
    background: #FFFFE3;
    padding: 80px 20px;
    text-align: center;
}

/* Title Styling */
.wave-section h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #2E2E2E;
    margin-bottom: 20px;
}

/* Paragraph Styling */
.wave-section p {
    font-size: 1.2rem;
    color: #65737E;
    margin-bottom: 10px;
    display: inline-block;
}

/* Button Styling */
.wave-section .cta-btn {
    display: inline-block;
    margin-top: 20px;
    background: #4FB4A8;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: background 0.9s ease-in-out;
}

.wave-section .cta-btn:hover {
    background: #3B4A6B;
}


    </style>

   <section class="wave-section">
    <div class="container mx-auto">
        <h1>WHY TEAMO DIGITAL SOLUTIONS <br>(TDS)?</h1>
        <p class="wave-text">We digitize your organization's entire historical archive,</p>
        <p class="wave-text">from inception to the present,</p>
        <p class="wave-text">into a seamless centralized digital system.</p>
        <a href="index.php?page=services" class="cta-btn">Explore Our Services</a>
    </div>
    </section>


        <!-- Our Customers Section -->
        <section class="bg-[#DBDBC3] py-10 overflow-hidden relative">
    <h2 class="text-4xl font-bold text-[#2E2E2E] text-center mb-8"><a href="index.php?page=clients_details">Our Trusted Clients</a></h2>

    <div class="w-full flex items-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#F4F4F2] via-transparent to-[#F4F4F2] z-10"></div>

        <!-- Scrolling Container -->
        <div class="flex space-x-15 animate-scroll w-max">
            
            <!-- Customer Logos (Duplicate for Infinite Effect) -->
            <img src="/myphpproject/public/images/client1.jpg" class="h-16 w-auto object-contain wave-motion" alt="customer1">
            <img src="/myphpproject/public/images/client2.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 2">
            <img src="/myphpproject/public/images/client1.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 3">
            <img src="/myphpproject/public/images/client2.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 4">
            <img src="/myphpproject/public/images/client1.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 5">
            <img src="/myphpproject/public/images/client2.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 6">

            <!-- Duplicate for Smooth Infinite Effect -->
            <img src="/myphpproject/public/images/client1.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 1">
            <img src="/myphpproject/public/images/client2.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 2">
            <img src="/myphpproject/public/images/client1.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 3">
            <img src="/myphpproject/public/images/client2.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 4">
            <img src="/myphpproject/public/images/client1.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 5">
            <img src="/myphpproject/public/images/client2.jpg" class="h-16 w-auto object-contain wave-motion" alt="Client 6">
        </div>


    </div>
    <style >
        
        @keyframes scroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

@keyframes wave {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(5px); }
}

.animate-scroll {
  display: flex;
  animation: scroll 15s linear infinite;
  white-space: nowrap;
}

.wave-motion {
  animation: wave 2s ease-in-out infinite;
}
 
/* Testimonials Section */
.testimonials-section {
    text-align: center;
    padding: 50px 15px;
}

/* Testimonials Heading */
.testimonials-heading {
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
    text-transform: uppercase;
    margin-bottom: 30px;
}

/* Testimonials Container */
.testimonials-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
    justify-items: center;
}

/* Individual Testimonial */
.testimonial {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.testimonial:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

/* Testimonial Content */
.testimonial-content {
    padding: 10px;
}

.testimonial-logo {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 15px;
}

/* Testimonial Text */
.testimonial-text {
    font-size: 1.2rem;
    font-style: italic;
    color: #555;
    margin-bottom: 15px;
    line-height: 1.6;
}

/* Author Name */
.author-name {
    font-size: 1rem;
    color: #007bff;
    font-weight: bold;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .testimonials-container {
        grid-template-columns: 1fr;
        padding: 0 20px;
    }

    .testimonial {
        padding: 15px;
    }

    .testimonial-text {
        font-size: 1rem;
    }

    .author-name {
        font-size: 0.9rem;
    }
}
    </style>

   <div class="testimonials-section">
    <h2 class="testimonials-heading">Testimonials</h2>
    <div class="testimonials-container">
        <?php
        $stmt = $pdo->query("SELECT * FROM testimonials INNER JOIN clients ON testimonials.client_id = clients.id");
        $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($testimonials as $row) {
            echo "<div class='testimonial'>
                <div class='testimonial-content'>
                    <img src='uploads/" . htmlspecialchars($row['logo']) . "' alt='" . htmlspecialchars($row['name']) . "' class='testimonial-logo'>
                    <p class='testimonial-text'>\"" . htmlspecialchars($row['testimonial_text']) . "\"</p>
                    <p class='author-name'>- <strong>" . htmlspecialchars($row['author_name']) . "</strong></p>
                </div>
            </div>";
        }
        ?>
    </div>
</div>


</section>



     <style>
/* 🔹 Ensure the services section is properly positioned */
.services-section {
    background: #8A8A7B;
    color: white;
    text-align: center;
    padding: 60px 0;
    position: relative; /* ✅ Prevents overlap */
    z-index: 10; /* ✅ Ensures it's above other sections */
}

/* 🔹 Title */
.section-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 30px;
}

/* 🔹 Container (Flexbox for even spacing) */
.services-container {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
    min-height: 200px; /* ✅ Prevents height collapsing */
}

/* 🔹 Service Cards */
.service-card {
    background: white;
    color: #2c3e50;
    width: 500px;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
    text-align: center;
    opacity: 1;
    transition: opacity 0.8s ease-in-out, transform 0.8s ease-in-out;
}

/* 🔹 Hide the cards before transition */
.service-card.hidden {
    opacity: 0;
    transform: scale(0.95);
}

/* 🔹 Service Icon */
.service-icon {
    width: 150px;
    height: 150px;
    margin-bottom: 15px;
}

/* 🔹 Service Title */
.service-title {
    font-size: 1.5rem;
    font-weight: bold;
}

/* 🔹 Ensure spacing between sections */
.services-section {
    margin-bottom: 10px; /* ✅ Pushes it away from gallery */
}


</style>
<section class="services-section">
    <h2 class="section-title">Our Core Services</h2>
    <div class="services-container">
        <div class="service-card">
            <img class="service-icon" src="/myphpproject/public/images/consultancy.jpg" alt="Consultancy">
            <h3 class="service-title">Consultancy</h3>
        </div>
        <div class="service-card">
            <img class="service-icon" src="/myphpproject/public/images/digitization.png" alt="Digitization & Digitalization">
            <h3 class="service-title">Digitization & Digitalization</h3>
        </div>
    </div>
</section>


 <script>
     document.addEventListener("DOMContentLoaded", function () {
    const servicesContainer = document.querySelector(".services-container");

    if (!servicesContainer) return; // ✅ Prevent errors if section is missing

    const services = [
        { img: "/myphpproject/public/images/consultancy.jpg", title: "Consultancy" },
        { img: "/myphpproject/public/images/digitization.png", title: "Digitization & Digitalization" },
        { img: "/myphpproject/public/images/web-development.jpg", title: "Software Development" },
        { img: "/myphpproject/public/images/it-support.png", title: "IT Support" }
    ];

    let currentSet = 0;

    function switchServices() {
        const serviceCards = servicesContainer.querySelectorAll(".service-card");

        // Fade out effect before changing content
        serviceCards.forEach(card => card.classList.add("hidden"));

        setTimeout(() => {
            // Update service content for two cards at a time
            serviceCards[0].innerHTML = `
                <img class="service-icon" src="${services[currentSet].img}" alt="${services[currentSet].title}">
                <h3 class="service-title">${services[currentSet].title}</h3>
            `;
            serviceCards[1].innerHTML = `
                <img class="service-icon" src="${services[(currentSet + 1) % services.length].img}" alt="${services[(currentSet + 1) % services.length].title}">
                <h3 class="service-title">${services[(currentSet + 1) % services.length].title}</h3>
            `;

            // Apply fade-in effect and reset scale
            serviceCards.forEach(card => {
                card.classList.remove("hidden");
                card.style.transform = "scale(1)";
            });

            // Cycle through services in pairs
            currentSet = (currentSet + 2) % services.length;
        }, 800); // Sync with the transition duration
    }

    // Auto-switch services every 5 seconds
    setInterval(switchServices, 5000);
});

    </script>


<!-- ✅ Display Recent Blogs Section -->
<section class="recent-blogs">
    <h2>Latest Blog Posts</h2>
    <div class="blog-container">
        <?php foreach ($blogs as $blog): ?>
            <div class="blog-card">
                <img src="<?= htmlspecialchars($blog['thumbnail']); ?>" alt="<?= htmlspecialchars($blog['title']); ?>">
                <h3><?= htmlspecialchars($blog['title']); ?></h3>
                <p><?= htmlspecialchars(substr($blog['content'], 0, 150)) . '...'; ?></p> <!-- Show 150 chars -->
                <a href="index.php?page=blog_detail&id=<?= $blog['id']; ?>" class="read-more">Read More</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
 
 <!-- Blog Styling -->
 <style>
     /* ✅ Recent Blogs Section */
.recent-blogs {
    padding: 50px 20px;
    background: #f8f9fa;
    text-align: center;
}

.recent-blogs h2 {
    font-size: 2.5rem;
    color: #3B4A6B;
    margin-bottom: 20px;
}

.blog-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.blog-card {
    width: 280px;
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
}

.blog-card:hover {
    transform: translateY(-5px);
}

.blog-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
}

.blog-card h3 {
    font-size: 1.2rem;
    color: #333;
    margin-top: 10px;
}

.blog-card p {
    font-size: 0.9rem;
    color: #666;
    margin: 10px 0;
}

.read-more {
    display: inline-block;
    margin-top: 10px;
    text-decoration: none;
    color: #4FB4A8;
    font-weight: bold;
}

.read-more:hover {
    text-decoration: underline;
}

 </style>

<!-- ✅ CSS Styling -->
<style>
    .recent-blogs {
        background: #f8f9fa;
        padding: 60px 20px;
        text-align: center;
    }
    .section-title {
        font-size: 2.5rem;
        color: #2E2E2E;
    }
    .section-subtitle {
        font-size: 1.2rem;
        color: #65737E;
        margin-bottom: 30px;
    }
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        max-width: 1200px;
        margin: auto;
    }
    .blog-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
    }
    .blog-card:hover {
        transform: scale(1.03);
    }
    .blog-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .blog-content {
        padding: 20px;
    }
    .blog-title {
        font-size: 1.5rem;
        color: #3B4A6B;
        margin-bottom: 10px;
    }
    .blog-excerpt {
        font-size: 1rem;
        color: #65737E;
        margin-bottom: 15px;
    }
    .read-more {
        display: inline-block;
        color: #4FB4A8;
        text-decoration: none;
        font-weight: bold;
    }
    .read-more:hover {
        color: #2E2E2E;
    }
</style>


<section>
<style>
.gallery-section {
    background-color: #DBDBC3; /* ✅ Full Section Background */
    padding: 50px 0;
    text-align: center;
}

.gallery-container {
    width: 90%;
    max-width: 1200px;
    margin: auto;
    overflow: hidden;
    position: relative;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.gallery-image {
    width: 100%;
    height: 400px; /* ✅ Ensures consistent height */
    object-fit: contain; /* ✅ Prevents cropping */
    /*background-color: #ffffff; /* ✅ Background for transparent images */
    border-radius: 8px;
}

.gallery-caption {
    font-size: 1.2rem;
    font-weight: bold;
    color: white; /* ✅ Always visible */
    padding: 15px 10px;
    background: rgba(0, 0, 0, 0.6); /* ✅ Semi-transparent background */
    border-radius: 5px;
    width: 100%;
    position: absolute;
    bottom: 10px; /* ✅ Always stays at the bottom */
    left: 0;
    text-align: center;
}



</style>
   <section class="gallery-section">
    <h2 class="gallery-title">Our Past Projects</h2>
    <div class="gallery-container">
        <div class="gallery-image">
            <img id="galleryImg" src="/myphpproject/public/images/project1.jpg" alt="Project 1">
            <div class="gallery-description" id="galleryDesc">
                <h3>Web Development Project</h3>
                <p>We designed a modern and responsive website for a top tech startup.</p>
            </div>
        </div>
    </div>

</section>

<script >
    // Array of Projects
const projects = [
    {
        img: "/myphpproject/public/images/project1.jpg",
        title: "Web Development Project",
        description: "We designed a modern and responsive website for a top tech startup."
    },
    {
        img: "/myphpproject/public/images/project2.jpg",
        title: "E-Commerce Store",
        description: "Built a fully functional e-commerce website with secure payments."
    },
    {
        img: "/myphpproject/public/images/project3.jpg",
        title: "Mobile App Design",
        description: "Designed an intuitive and engaging mobile app UI for a fintech company."
    },
    {
        img: "/myphpproject/public/images/project4.jpg",
        title: "Branding & Logo Design",
        description: "Created a unique brand identity for a leading fashion brand."
    }
];

let currentIndex = 0;

function changeGalleryImage() {
    const imgElement = document.getElementById("galleryImg");
    const descElement = document.getElementById("galleryDesc");

    currentIndex = (currentIndex + 1) % projects.length;

    imgElement.src = projects[currentIndex].img;
    imgElement.onerror = function () {
        console.error("Image not found:", projects[currentIndex].img);
    };

    descElement.innerHTML = `<h3>${projects[currentIndex].title}</h3><p>${projects[currentIndex].description}</p>`;
}

// Change image every 3 seconds
setInterval(changeGalleryImage, 3000);

</script>
</section>

<?php include __DIR__ . "/footer.php"; ?>

</body>
</html>
