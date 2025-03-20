<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - CodeForum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Hero Section */
        .hero {
            background: rgb(133, 243, 150);
            color: black;
            padding: 100px 0;
            text-align: center;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInUp 1s forwards;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        /* Section Styling */
        .section-content {
            padding: 60px 0;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s forwards 0.5s;
        }

        .feature-box {
            transition: transform 0.3s ease-in-out;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s forwards 0.7s;
        }

        .feature-box:hover {
            transform: translateY(-10px);
        }

        .feature-box i {
            font-size: 40px;
            color: #6a11cb;
            margin-bottom: 15px;
        }

        /* Call to Action */
        .cta {
            background:rgb(133, 243, 150);
            color: black;
            padding: 50px 0;
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s forwards 1s;
        }

        .cta h2 {
            font-size: 2.5rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<?php include 'partials/_dbConnect.php'; ?>
<?php include "partials/_header.php"; ?> 

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Welcome to CodeForum</h1>
        <p class="lead">A hub for developers to collaborate, innovate, and grow.</p>
    </div>
</section>

<!-- About Section -->
<section class="container section-content">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2>Our Mission</h2>
            <p>At CodeForum, we aim to cultivate a thriving community where developers can share insights, solve challenges, and stay ahead in the ever-evolving tech world.</p>
            <p>Whether you're a beginner or an expert, our platform empowers you to learn, teach, and connect with like-minded professionals.</p>
        </div>
        <div class="col-md-6 text-center">
            <img src="images/coding-team.webp" class="img-fluid rounded" alt="Coding Forum" width="350" height="150">
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="bg-light section-content">
    <div class="container text-center">
        <h2>Why Choose CodeForum?</h2>
        <div class="row mt-4">
            <div class="col-md-4 feature-box">
                <i class="bi bi-code-slash"></i>
                <h4>Industry Insights</h4>
                <p>Engage with experts and stay updated with cutting-edge technologies.</p>
            </div>
            <div class="col-md-4 feature-box">
                <i class="bi bi-people-fill"></i>
                <h4>Global Community</h4>
                <p>Network with developers from around the world and exchange ideas.</p>
            </div>
            <div class="col-md-4 feature-box">
                <i class="bi bi-lightbulb"></i>
                <h4>Knowledge Sharing</h4>
                <p>Learn, contribute, and enhance your skills through discussions and tutorials.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta">
    <div class="container">
        <h2>Join CodeForum Today</h2>
        <p>Be a part of a growing community that empowers developers to achieve more.</p>
        <button type="button" class="btn btn-light btn-lg mt-2" data-bs-toggle="modal" data-bs-target="#signupModal"> Get Started
        </button>   
        </div>
</section>

<!-- Footer -->
<?php include "partials/_footer.php" ?>

</body>
</html>