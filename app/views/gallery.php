<?php include __DIR__ . "/header.php"; ?>

<!-- ✅ Gallery Section - Adjusted for Proper Spacing -->
<div class="gallery-container">
    <div class="gallery-wrapper">
        <h1 class="gallery-title">Our Past Projects</h1>
        <p class="gallery-description">
            Explore some of our amazing past projects. Click on any image to view in full-screen mode.
        </p>

        <!-- ✅ Filter Buttons -->
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="consulting">Consulting</button>
            <button class="filter-btn" data-filter="digitization">Digitization</button>
            <button class="filter-btn" data-filter="software">Software Development</button>
            <button class="filter-btn" data-filter="it-support">IT Support</button>
        </div>

        <!-- ✅ Gallery Grid -->
        <div class="gallery-grid">
            <?php
            $images = [
                ["path" => "/myphpproject/public/images/project1.jpg", "category" => "consulting", "title" => "Business Consulting"],
                ["path" => "/myphpproject/public/images/project2.jpg", "category" => "digitization", "title" => "Data Digitization"],
                ["path" => "/myphpproject/public/images/project3.jpg", "category" => "software", "title" => "Custom Software Development"],
                ["path" => "/myphpproject/public/images/project4.jpg", "category" => "it-support", "title" => "IT Infrastructure Support"]
            ];

            foreach ($images as $image) {
                echo '
                <div class="gallery-item" data-category="'.$image["category"].'">
                    <img src="'.$image["path"].'" alt="'.$image["title"].'" onclick="openLightbox(this)">
                    <div class="gallery-caption">'.$image["title"].'</div>
                </div>';
            }
            ?>
        </div>
    </div>
</div>

<!-- ✅ Featured Animated Showcase -->
<section class="animated-showcase">
    <h2 class="animated-title">Our Proud Projects</h2>
    <p class="animated-description">See some of our best work, elegantly showcased one by one.</p>
    <div class="showcase-slider" id="showcaseSlider">
        <?php
        $showcaseProjects = [
            ["image" => "/myphpproject/public/images/project1.jpg", "title" => "Business Consulting", "desc" => "We helped transform businesses with innovative consulting strategies."],
            ["image" => "/myphpproject/public/images/project2.jpg", "title" => "Data Digitization", "desc" => "Modernizing record management with secure, accurate digitization services."],
            ["image" => "/myphpproject/public/images/project3.jpg", "title" => "Software Development", "desc" => "Custom software solutions tailored for business growth and automation."],
            ["image" => "/myphpproject/public/images/project4.jpg", "title" => "IT Infrastructure Support", "desc" => "Robust IT support and infrastructure design for continuous performance."]
        ];

        foreach ($showcaseProjects as $index => $project) {
            echo '
            <div class="slide'.($index === 0 ? ' active' : '').'">
                <img src="'.$project["image"].'" alt="'.$project["title"].'">
                <div class="slide-overlay">
                    <h3>'.$project["title"].'</h3>
                    <p>'.$project["desc"].'</p>
                </div>
            </div>';
        }
        ?>
    </div>
</section>


<!-- ✅ Lightbox Modal -->
<div id="lightbox" class="lightbox">
    <span class="close-lightbox" onclick="closeLightbox()">&times;</span>
    <img id="lightbox-img">
    <div id="lightbox-caption"></div>
</div>

<?php include __DIR__ . "/footer.php"; ?>

<!-- ✅ JavaScript for Lightbox and Filters -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    // ✅ Filtering Logic
    const filterButtons = document.querySelectorAll(".filter-btn");
    const galleryItems = document.querySelectorAll(".gallery-item");

    filterButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            document.querySelector(".filter-btn.active").classList.remove("active");
            btn.classList.add("active");

            const filter = btn.getAttribute("data-filter");
            galleryItems.forEach(item => {
                if (filter === "all" || item.getAttribute("data-category") === filter) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    });
});

// ✅ Lightbox Functionality
function openLightbox(img) {
    document.getElementById("lightbox").style.display = "flex";
    document.getElementById("lightbox-img").src = img.src;
    document.getElementById("lightbox-caption").innerText = img.alt;
}
function closeLightbox() {
    document.getElementById("lightbox").style.display = "none";
}
</script>

<script>
let currentSlide = 0;
const slides = document.querySelectorAll('#showcaseSlider .slide');

function showNextSlide() {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add('active');
}

setInterval(showNextSlide, 4000); // Change slide every 4 seconds
</script>


<!-- ✅ CSS Styles -->
<style>

/* ✅ Ensure Gallery Stays Clear from Header */
.gallery-container {
    text-align: center;
    background: #FFFFE3;
    padding: 80px 20px; /* Padding for internal spacing */
    min-height: 100vh; /* Ensures it doesn't overlap footer */
    margin-top: 20px; /* ✅ Pushes gallery below the header */
}
   margin: auto;
}
.gallery-title {
    font-size: 2.5rem;
    color: #ffffff;
}
.gallery-description {
    font-size: 1.2rem;
    color: #b0c4de;
    margin-bottom: 20px;
}

/* ✅ Filter Buttons */
.filter-buttons {
    margin-bottom: 20px;
}
.filter-btn {
    background: #4FB4A8;
    color: white;
    padding: 10px 15px;
    border: none;
    cursor: pointer;
    margin: 5px;
    border-radius: 5px;
    transition: 0.3s;
}
.filter-btn:hover, .filter-btn.active {
    background: #2E2E2E;
}

/* ✅ Animated Showcase Styling */
.animated-showcase {
    background: linear-gradient(135deg, #fdfcfb, #e2d1c3);
    padding: 80px 20px;
    text-align: center;
}
.animated-title {
    font-size: 2.5rem;
    margin-bottom: 10px;
    color: #333;
}
.animated-description {
    font-size: 1.2rem;
    color: #555;
    margin-bottom: 50px;
}
.showcase-slider {
    position: relative;
    width: 100%;
    max-width: 1000px;
    height: 500px;
    margin: 0 auto;
    overflow: hidden;
    border-radius: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.slide {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1s ease-in-out;
}
.slide.active {
    opacity: 1;
}
.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.slide-overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 20px;
    background: rgba(0, 0, 0, 0.65);
    color: #fff;
}
.slide-overlay h3 {
    font-size: 2rem;
    margin-bottom: 10px;
}
.slide-overlay p {
    font-size: 1rem;
}

/* ✅ Gallery Grid */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    max-width: 1200px;
    margin: auto;
}
.gallery-item {
    position: relative;
    overflow: hidden;
    cursor: pointer;
}
.gallery-item img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
}
.gallery-item:hover img {
    transform: scale(1.05);
}
.gallery-caption {
    position: absolute;
    bottom: 10px;
    left: 0;
    width: 100%;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 5px 0;
    text-align: center;
    font-size: 1rem;
    transition: 0.3s;
}
.gallery-item:hover .gallery-caption {
    background: rgba(0, 0, 0, 0.9);
}

/* ✅ Lightbox Modal */
.lightbox {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 999;
}
.lightbox img {
    max-width: 80%;
    max-height: 80%;
}
.close-lightbox {
    position: absolute;
    top: 20px; right: 30px;
    font-size: 30px;
    color: white;
    cursor: pointer;
}
#lightbox-caption {
    color: white;
    margin-top: 10px;
    font-size: 1.2rem;
}

/* ✅ Add Margin to Keep Footer Away */
footer {
    margin-top: 40px;
}
</style>
