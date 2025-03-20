<?php
include 'partials/_dbConnect.php';
include 'partials/_dbConnect.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    body {
        animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .hero-section {
        animation: bounceIn 1.2s ease-in-out;
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }

        60% {
            transform: scale(1.1);
            opacity: 1;
        }

        100% {
            transform: scale(1);
        }
    }

    .card {
        animation: slideUp 1.2s ease-in-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .send {
        transition: all 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .send::after {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.5s;
    }

    .send:hover::after {
        left: 100%;
    }

    .send:hover {
        transform: scale(1.05);
        background-color: rgb(133, 243, 150);
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    }

    .form-control {
        transition: 0.3s;
    }

    .form-control:focus {
        transform: scale(1.02);
        box-shadow: 0 0 10px rgb(133, 243, 150);
    }

    .map-section {
        animation: fadeInUp 1.5s ease-in-out;
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .form-label {
        transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
    }

    .form-control:focus+.form-label {
        transform: translateY(-20px);
        opacity: 0.7;
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php include "partials/_header.php"; ?>
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contacts (name, email, subject, message, created_at) VALUES ('$name', '$email', '$subject', '$message',  current_timestamp())";

    if (mysqli_query($conn, $sql)) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your Message has been sent successfully. Please wait for community to respond.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } else {
        $showError = $_GET['error'];
        echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
                <strong>Error!</strong> ' . $showError . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}
?>
    

    <!-- Hero Section -->
    <section class="hero-section text-white text-center py-5" style="background: rgb(133, 243, 150);">
        <div class="container" style="color:black;">
            <h1>Contact Us</h1>
            <p class="lead">Have questions or feedback? Reach out to us anytime.</p>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-lg">
                    <h2 class="text-center mb-4">Get in Touch</h2>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject"
                                placeholder="Subject of your message" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" name="message" id="message" rows="4"
                                placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success send w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Map Section -->
    <section class="container my-5 map-section">
        <h2 class="text-center mb-4">Our Location</h2>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <iframe src="https://www.google.com/maps/embed?..." class="w-100" height="350" style="border:0;"
                    allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include "partials/_footer.php"; ?>

</body>

</html>