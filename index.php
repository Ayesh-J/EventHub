<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EventHub | Manage College Events</title>
    <link rel="stylesheet" href="assets/css/landing.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="hero">
        <nav>
            <div class="logo">EventHub</div>
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#events">Events</a></li>
                <li><a href="users/login.php" class="login-btn">Login</a></li>
            </ul>
        </nav>

        <div class="hero-content">
            <h1>Manage. Organize. Celebrate.</h1>
            <p>Your one-stop solution to organize and register for college events effortlessly.</p>
            <a href="users/register.php" class="cta-btn">Get Started</a>
        </div>

        <div class="overlay"></div>
    </div>

    <section class="features" id="features">
        <h2>What You Can Do</h2>
        <div class="feature-cards">
            <div class="card">
                <h3>Create Events</h3>
                <p>Admins can easily add and manage upcoming events with all essential details.</p>
            </div>
            <div class="card">
                <h3>Register Easily</h3>
                <p>Students can register for events by submitting their details in just a few clicks.</p>
            </div>
            <div class="card">
                <h3>Track Participation</h3>
                <p>Admins can track who’s participating in what with ease and download data.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> EventHub | Crafted with ❤️ by Team ByteForce</p>
    </footer>
</body>
</html>
