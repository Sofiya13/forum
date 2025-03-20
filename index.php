<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<style>
.card {
    transition: all 0.4s ease-in-out;
    border-radius: 15px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: 2px solid transparent;
    position: relative;
}

.card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    border: 2px solid var(--card-border-color, #007bff);
}

/* Dynamic Color Borders */
[data-lang="python"] {
    --card-border-color: #ffd43b;
}

[data-lang="javascript"] {
    --card-border-color: #f7df1e;
}

[data-lang="php"] {
    --card-border-color: #787cb5;
}

[data-lang="java"] {
    --card-border-color: #f89820;
}

[data-lang="bootstrap"] {
    --card-border-color: rgb(32, 61, 248);
}

[data-lang="c++"] {
    --card-border-color: #00599c;
}

[data-lang="html"] {
    --card-border-color: #e34f26;
}

[data-lang="css"] {
    --card-border-color: #264de4;
}

[data-lang="default"] {
    --card-border-color: #6c757d;
}

.card img {
    height: 150px;
    object-fit: contain;
    padding: 10px;
    border-radius: 10px;
    background: #f8f9fa;
    transition: transform 0.3s ease-in-out;
}

.card:hover img {
    transform: scale(1.1);
}

.card-body {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

.card-title a {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease-in-out;
}

.card-title a:hover {
    color: var(--card-border-color, #007bff);
}

.card-text {
    font-size: 14px;
    color: #666;
    text-align: center;
}

/* Button Colors */
.btn-dark {
    background: var(--card-border-color, #343a40);
    color: #fff;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    padding: 10px 18px;
    font-size: 14px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-dark:hover {
    background: var(--card-border-color, #007bff);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}
</style>

<body>
    <?php include 'partials/_dbConnect.php'; ?>
    <?php include 'partials/_header.php'; ?>


    <!-- carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/carousel1.webp" class="d-block w-100" alt="..." height="500px" width="100%">
            </div>
            <div class="carousel-item">
                <img src="images/carousel2.webp" class="d-block w-100" alt="..." height="500px" width="100%">
            </div>
            <div class="carousel-item">
                <img src="images/carousel3.webp" class="d-block w-100" alt="..." height="500px" width="100%">
            </div>
            <div class="carousel-item">
                <img src="images/carousel4.webp" class="d-block w-100" alt="..." height="500px" width="100%">
            </div>
            <div class="carousel-item">
                <img src="images/carousel5.webp" class="d-block w-100" alt="..." height="500px" width="100%">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <div class="container my-3">
        <h2 class="text-center my-3">CodeForum - Browse Categories</h2>
        <div class="row px-3 justify-content-center">
            <?php
        $sql = "SELECT * FROM `categories`";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['category_id'];
            $cat = $row['category_name'];
            $desc = $row['category_description'];
            $imageURL = "https://skillicons.dev/icons?i=".strtolower($cat);
            // Category-based colors
            $categoryColors = [
                "python" => "python",
                "javascript" => "javascript",
                "php" => "php",
                "java" => "java",
                "c++" => "c++",
                "html" => "html",
                "bootstrap" => "bootstrap",
                "css" => "css"
            ];

            // Get category name in lowercase for matching
            $categoryKey = strtolower($cat);
            $langClass = isset($categoryColors[$categoryKey]) ? $categoryColors[$categoryKey] : "default";

            echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4 m-4" data-lang="'.$langClass.'">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <img src="'.$imageURL.'" class="card-img-top" alt="Category Image">
                        <div class="card-body d-flex flex-column text-center">
                            <h5 class="card-title">
                                <a href="threadlist.php?catid='. $id .'" class="text-decoration-none">'. $cat .'</a>
                            </h5>
                            <p class="card-text">'.substr($desc, 0, 100).'...</p>
                            <a href="threadlist.php?catid='. $id .'" class="btn btn-dark mt-auto">Explore <i class="fas fa-code"></i></a>
                        </div>
                    </div>
                </div>';

                            
        }
        ?>
        </div>
    </div>

    <?php include 'partials/_footer.php'; ?>

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</html>