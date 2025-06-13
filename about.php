<?php
require_once 'config.php';
require_once 'functions.php';

$page_title = 'About Us';

include 'header.php';
?>

<!-- About Hero -->
<section class="hero about-hero">
    <div class="hero-content">
        <h1>Our Story</h1>
        <p>Passion for perfection in every bite</p>
    </div>
</section>

<!-- Story Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title">About GOURMET</h2>
        <div class="about-grid">
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Our bakery">
            </div>
            <div class="about-content">
                <p>GOURMET was founded in 2010 by Chef Marie Laurent, who trained at the prestigious Le Cordon Bleu in Paris. What began as a small patisserie has grown into a beloved destination for dessert enthusiasts and those celebrating special occasions.</p>
                <p>Our philosophy is simple: use only the finest ingredients, honor traditional techniques, and infuse each creation with creativity and passion. We source local, organic ingredients whenever possible and never use artificial preservatives or flavors.</p>
                <p>Every cake, pastry, and dessert that leaves our kitchen is crafted with meticulous attention to detail. We believe that desserts should not only taste extraordinary but should also be visually stunning – true edible works of art.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="section bg-light">
    <div class="container">
        <h2 class="section-title">Meet Our Team</h2>
        <div class="team-grid">
            <div class="team-card">
                <div class="team-image">
                    <img src="https://images.unsplash.com/photo-1566554273541-37a9ca77b91f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Chef Marie Laurent">
                </div>
                <div class="team-content">
                    <h3>Chef Marie Laurent</h3>
                    <p class="team-role">Founder & Head Pastry Chef</p>
                    <p>Trained at Le Cordon Bleu, Paris with over 20 years of experience in fine pastry.</p>
                </div>
            </div>

            <div class="team-card">
                <div class="team-image">
                    <img src="https://images.unsplash.com/photo-1583394293214-28ded15ee548?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Chef Thomas Wilson">
                </div>
                <div class="team-content">
                    <h3>Chef Thomas Wilson</h3>
                    <p class="team-role">Master Baker</p>
                    <p>Specializes in artisanal breads and classic European pastries with a modern twist.</p>
                </div>
            </div>

            <div class="team-card">
                <div class="team-image">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Sophia Chen">
                </div>
                <div class="team-content">
                    <h3>Sophia Chen</h3>
                    <p class="team-role">Cake Designer</p>
                    <p>Award-winning cake artist known for her intricate sugar flowers and innovative designs.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Visit Us</h2>
        <div class="location-grid">
            <div class="map-placeholder">
                <p>Google Map Placeholder</p>
            </div>
            <div class="location-content">
                <h3>Our Location</h3>
                <p><strong>Address:</strong> 123 Baker Street, Sweetville, CA 12345</p>
                <p><strong>Phone:</strong> (123) 456-7890</p>
                <p><strong>Email:</strong> info@gourmet.com</p>
                
                <h3>Hours</h3>
                <p><strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM</p>
                <p><strong>Saturday:</strong> 10:00 AM - 5:00 PM</p>
                <p><strong>Sunday:</strong> Closed</p>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
