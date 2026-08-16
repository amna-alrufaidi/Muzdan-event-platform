<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUZDAN</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>

    <!-- ===== Header ===== -->

    <header>

        <div class="logo-section">
            <img src="logo.jpg" alt="MUZDAN Logo">
            <h1>MUZDAN</h1>
        </div>

        <nav>
             <a href="home.php">Home</a>
            <a href="services.php">Services</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="home.php">English</a>
            <a href="home_ar.php">العربية</a>
        </nav>

    </header>

    <!-- ===== Hero Section ===== -->

    <section class="hero">

        <div class="hero-text">

            <h2>All Event Services In One Place!</h2>

            <p>
                MUZDAN is a smart platform that helps users find event services easily such as halls, flowers,
                catering, decorations, and more in one organized website.
            </p>

            <div class="buttons">
                <a href="register.php" class="register-btn">
                    Create Account
                </a>

                <a href="login.php" class="login-btn">
                    Login
                </a>
            </div>
            <div class="provider-btn-container">
                <a href="provider.php" class="provider-btn">
                   Join us as a Service Provider
                </a>
            </div>

        </div>

        <div class="hero-image">
            <img id="slider" src="event.jpg" alt="Event Image">
        </div>

    </section>

    <!-- ===== Features ===== -->

    <section class="features">

        <div class="card">
            <center>
              <img src="search.jpg" alt="search" width="200" height="150" >
            </center>
            <h3>Easy Search</h3>
            <p>
                Browse and search for event services quickly
                with organized categories and filters.
            </p>
        </div>

        <div class="card">
             <center>
              <img src="trust.jpg" alt="trust provider" width="200" height="150" >
            </center>
            <h3>Trusted Providers</h3>
            <p>
                Connect with verified service providers and
                explore their details and reviews.
            </p>
        </div>

        <div class="card">
             <center>
              <img src="time.jpg" alt="save time" width="200" height="150" >
            </center>
            <h3>Save Time</h3>
            <p>
                Find everything you need for your event in one
                platform without searching multiple websites.
            </p>
        </div>

    </section>

    <!-- ===== Footer ===== -->

    <footer>
        © 2026 MUZDAN | All Rights Reserved
    </footer>

</body>
</html>