<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nala Media Digital Printing</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: gray;
            color: black;
            overflow-x: hidden;
        }

        /* Header */
        header {
            background-color: gray;
            color: white;
            padding: 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        /* Banner Section */
        .banner {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 80px 20px;
            margin-top: 10px;
            transition: opacity 0.3s ease-in-out;
            opacity: 1;
        }

        .banner h2 {
            font-size: 42px;
        }

        .banner p {
            font-size: 24px;
        }

        /* Services Section */
        #services {
            text-align: center;
            padding: 60px 20px;
        }

        #services h2 {
            font-size: 36px;
            margin-bottom: 40px;
        }

        .service {
            background-color: #f1f1f1;
            padding: 20px;
            margin: 15px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            width: 90%;
            max-width: 800px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            text-decoration: none;
            color: inherit;
        }

        .service:hover {
            transform: translateY(-10px);
        }

        .service i {
            font-size: 30px;
            color: #333;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .service h3 {
            font-size: 24px;
            margin: 0;
            flex-grow: 1;
        }

        /* Footer Section */
        footer {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #services .service {
                width: 95%;
                margin: 10px auto;
            }

            #services h2 {
                font-size: 32px;
            }

            .service {
                flex-direction: row;
                padding: 15px;
                justify-content: center;
                align-items: center;
            }

            .service i {
                margin: 0 15px 0 0;
            }

            .service h3 {
                text-align: center;
            }

            .banner h2 {
                font-size: 28px;
            }

            .banner p {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

    <!-- Header and Navbar -->
    <header>
        <div class="navbar">
            <h1>Nala Media</h1>
        </div>
    </header>

    <!-- Banner Section -->
    <section id="home">
        <div class="banner">
            <h2>Nala Media Digital Printing</h2>
            <p>Solusi Percetakan Terbaik untuk Bisnis Anda</p>
            <p style="margin-top: -15px; font-size: 14px;">Cetak MMT, Banner, Spanduk dan berbagai kebutuhan bisnis Anda dengan kualitas terbaik dan harga terjangkau.</p>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services">
        <a href="https://www.google.com/maps/place/Nala+Media+Digital+Printing/@-7.5954395,110.9469096,17z/data=!3m1!4b1!4m6!3m5!1s0x2e7a2333cdf28a07:0xd56d305d315c7bca!8m2!3d-7.5954395!4d110.9494899!16s%2Fg%2F11t57xfr7z?entry=ttu&g_ep=EgoyMDI0MTEwNi4wIKXMDSoASAFQAw%3D%3D" class="service" target="_blank">
            <i class="fas fa-map-marker-alt"></i>
            <h3>Lokasi</h3>
        </a>
        <a href="https://www.instagram.com/nalamedia.kra" class="service" target="_blank">
            <i class="fab fa-instagram"></i>
            <h3>Instagram</h3>
        </a>
        <a href="https://www.facebook.com/profile.php?id=100094337075154&mibextid=ZbWKwL" class="service" target="_blank">
            <i class="fab fa-facebook"></i>
            <h3>Facebook</h3>
        </a>
        <a href="https://s.shopee.co.id/8pQiWgdXs1" class="service" target="_blank">
            <i class="fas fa-shopping-bag"></i>
            <h3>Shopee</h3>
        </a>
        <a href="https://wa.me/6281398727722" class="service" target="_blank">
            <i class="fab fa-whatsapp"></i>
            <h3>WhatsApp</h3>
        </a>
    </section>

    <!-- Footer Section -->
    <footer id="contact">
        <div class="contact-info">
            <p>&copy; 2024 Nala Media Digital Printing By Richzal</p>
        </div>
    </footer>
</body>
</html>
