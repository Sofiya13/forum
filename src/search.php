<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php include 'partials/_dbConnect.php'; ?>
    <?php include 'partials/_header.php'; ?>


    <div class="container my-3 d-flex justify-content-center">
        <div class="w-75">
            <h1 class="py-3">Search results for <em>"<?php echo htmlspecialchars($_GET['search']); ?></em>"</h1>

            <?php 
                $noresults = true;
                $query = $_GET['search'];
                $sql = "SELECT * FROM `threads` WHERE MATCH(thread_title, thread_desc) against ('$query')";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row['thread_title'];
                    $desc = $row['thread_desc'];    
                    $thread_id = $row['thread_id'];
                    $url = "thread.php?threadid=". $thread_id;
                    $noresults = false;

                    echo '<div class="result">
                            <h3><a href="'. $url .'" class="text-dark ">'.$title.'</a></h3>
                            <p>'.$desc.'</p>
                        </div>';
                }
                if($noresults){
                    echo '<div class="card bg-light my-3">
                            <div class="card-body">
                                <h2 class="display-4">No Results Found</h2>
                                <p class="lead">Suggestions: <ul>
                                             <li>Check your spelling.</li>
                                             <li>Try more general words.</li>
                                             <li>Try different words that mean the same thing.</li></ul>
                                </p>
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