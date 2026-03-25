<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | Wadap Maids</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 40px;
            max-width: 1200px;
            margin: auto;
        }
        .service-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            border-top: 5px solid #d4af37; /* Wadap Gold */
        }
        .service-card:hover { transform: translateY(-10px); }
        .service-card h3 { color: #0b3d2c; margin-bottom: 15px; }
        .service-card p { color: #666; font-size: 0.95rem; line-height: 1.6; }
        .price-tag { 
            display: inline-block;
            margin-top: 15px;
            font-weight: bold;
            color: #0b3d2c;
            background: #f1d592;
            padding: 5px 15px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="form-header">
    <h1>Our Professional Services</h1>
    <p>Expert Cleaning Solutions for Every Need</p>
</div>

<div class="services-grid">
    <div class="service-card">
        <h3>Basic House Cleaning</h3>
        <p>General dusting, mopping, and vacuuming for a fresh daily home environment.</p>
        <span class="price-tag">From RM25/hr</span>
    </div>

    <div class="service-card">
        <h3>Deep Cleaning</h3>
        <p>Intensive scrub of bathrooms, kitchens, and hard-to-reach areas. Highly recommended for first-timers.</p>
        <span class="price-tag">From RM50/hr</span>
    </div>

    <div class="service-card">
        <h3>Office & Commercial</h3>
        <p>Maintain a professional workspace with our customized office maintenance packages.</p>
        <span class="price-tag">Contact for Quote</span>
    </div>

    <div class="service-card">
        <h3>Move In/Out Cleaning</h3>
        <p>Full sanitization before you move into your new home or to get your deposit back.</p>
        <span class="price-tag">From RM150</span>
    </div>

    <div class="service-card">
        <h3>Post-Renovation</h3>
        <p>Removing fine construction dust and debris after your home makeover is complete.</p>
        <span class="price-tag">Custom Quote</span>
    </div>

    <div class="service-card">
        <h3>Sofa & Carpet Cleaning</h3>
        <p>Professional steam cleaning to remove stains and allergens from your upholstery.</p>
        <span class="price-tag">From RM80</span>
    </div>

    <div class="service-card">
        <h3>Homestay/Airbnb Prep</h3>
        <p>Quick turnaround cleaning and linen changes for high-rated guest experiences.</p>
        <span class="price-tag">RM40/session</span>
    </div>
</div>

<div style="text-align: center; margin-bottom: 50px;">
    <a href="booking.php" class="btn-gold" style="padding: 15px 40px; text-decoration: none; border-radius: 30px;">Book Now</a>
</div>

</body>
</html>