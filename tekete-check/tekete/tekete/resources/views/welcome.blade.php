<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        :root {
            --font-family: Arial, sans-serif;
            --line-height: 1.6;
            --text-color: #3b3b3b;
            --background-light: #f5f5f5;
            --background-hero: linear-gradient(to right, #ffffff, #e0e0e0);
            --background-feature: #ffffff;
            --primary-color: #a1a80f;
            --primary-hover: #808a0b;
            --border-radius: 10px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            line-height: var(--line-height);
            color: var(--text-color);
        }

        header {
            background-color: var(--background-light);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .logo span {
            font-size: 1.5em;
            font-weight: bold;
            color: var(--primary-color);
        }

        nav {
            display: flex;
            gap: 15px;
        }

        nav a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
        }

        nav a:hover {
            color: var(--primary-color);
        }

        .hero {
            text-align: left;
            padding: 50px 20px;
            background: var(--background-hero);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hero-content {
            max-width: 50%;
        }

        .hero h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 20px;
            color: var(--text-color);
        }

        .cta-buttons {
            display: flex;
            gap: 10px;
        }

        .cta-button {
            background-color: var(--primary-color);
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 1em;
            border-radius: var(--border-radius);
        }

        .cta-button:hover {
            background-color: var(--primary-hover);
        }

        .hero img {
            max-width: 40%;
            height: auto;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 40px 20px;
            background-color: var(--background-feature);
        }

        .feature {
            background-color: #fff;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            flex: 1 1 calc(33.333% - 40px);
            max-width: 300px;
        }

        .feature h3 {
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .feature p {
            font-size: 0.9em;
            color: var(--text-color);
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: var(--background-light);
        }

        footer p {
            font-size: 0.9em;
            color: var(--text-color);
        }

        @media (max-width: 768px) {
            .features {
                flex-direction: column;
                align-items: center;
            }

            .feature {
                max-width: 100%;
                flex: none;
            }

            header {
                flex-direction: column;
                gap: 10px;
            }

            .hero {
                flex-direction: column;
                text-align: center;
            }

            .hero-content {
                max-width: 100%;
            }

            .hero img {
                max-width: 80%;
            }

            .cta-buttons {
                justify-content: center;
            }
        }

        .about-section {
            padding: 40px 20px;
            background-color: var(--background-light);
            background-image: 
        }

        .about-section h2 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .about-section p {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Tekete Logo">
            <span>Tekete</span>
        </div> 
        {{-- <div class="text-center mb-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid" style="width: 70px; height: 70px;">
        </div> --}}
        <nav>
            <a href="#">Home</a>
            <a href="#features">Features</a>
            <a href="#">Services</a>
            <a href="#">Contact</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Tekete Management System</h1>
            <p>Your solution to automated customer care and efficient service tracking.</p>
            <div class="cta-buttons">
                <a href="{{ route('login') }}" class="cta-button">Log In</a>
                <a href="{{ route('register') }}" class="cta-button">Register</a>
            </div>
        </div>
     <img src="{{asset('images/technician.png')}}" alt="Customer Support Illustration"> 
    </section>

    <section class="about-section">
        <h2>Get to Know About Tekete</h2>
        <p>
            Tekete Management System is an automated customer care system that allows customers to log tickets for service issues. Our system is designed to help you log and report computer incidents you experience with your personal computer. The system helps users within organizations manage and report incidents more easily and efficiently. Customers can register, log in, retrieve passwords, capture service requests, and track these requests through a single, easy-to-use interface.
        </p>
        <p>
            The solution covers channels such as Web portal, Mobile App, calling service Desk, Email, and WhatsApp chat board. Our system allows users to report incidents such as Forgotten passwords, Slow performance, Unrecognized USB, Network problems, Random shutdowns, and more.
        </p>
    </section>

    <section  id="features" class="features">
        <div class="feature">
            <h3>Forgotten Passwords</h3>
            <p>Quickly address issues like forgotten passwords and slow performance.</p>
        </div>
        <div class="feature">
            <h3>Network Issues</h3>
            <p>Resolve problems with Wi-Fi, Ethernet, and connectivity effectively.</p>
        </div>
        <div class="feature">
            <h3>Communication Channels</h3>
            <p>Contact support via service desk, email, or WhatsApp chat board.</p>
        </div>
        <div class="feature">
            <h3>System Reliability</h3>
            <p>Track and resolve random shutdowns and other critical issues.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Tekete Management System. All rights reserved.</p>
    </footer>
</body>
</html>