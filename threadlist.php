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

    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
        if($method =='POST'){
            $th_title = $_POST['title'];
            $th_desc = $_POST['desc'];

            $th_title = str_replace("<", "&lt;", $th_title);
            $th_title = str_replace(">", "&gt;", $th_title);

            $th_desc = str_replace("<", "&lt;", $th_desc);
            $th_desc = str_replace(">", "&gt;", $th_desc);

            $sno = $_POST['sno'];

            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
                if($showAlert){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your thread has been added successfully. Please wait for community to respond.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                } 
         }
?>
<div class="container col-lg-8 my-4" style="margin-top: 100px;">
    <div class="card bg-light forum-rules p-3">
        <div class="card-body">
            <h2 class="display-4">Welcome to <?php echo $catname; ?> Forums</h2>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="bi bi-check-circle text-success"></i> <strong>Be Respectful & Professional</strong> – Treat all members with kindness and professionalism.</li>
                <li class="list-group-item"><i class="bi bi-chat-left-text text-primary"></i> <strong>Stay On Topic</strong> – Keep discussions relevant to the category and avoid unnecessary diversions.</li>
                <li class="list-group-item"><i class="bi bi-code-slash text-danger"></i> <strong>Format Your Code Properly</strong> – Use code blocks for better readability when sharing code.</li>
                <li class="list-group-item"><i class="bi bi-shield-lock text-warning"></i> <strong>No Spam or Self-Promotion</strong> – Avoid posting irrelevant links or promotional content.</li>
            </ul>
        </div>
    </div>
</div>

<style>
    /* Hover Effect for List Items */
    .list-group-item:hover {
        background-color: #f8f9fa; /* Light gray hover effect */
        transition: 0.3s ease-in-out;
    }

    /* Sticky Notice for Forum Rules */
    .forum-rules {
        position: sticky;
        top: 20px;
        z-index: 1000;
    }
</style>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    <?php
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container col-lg-8 my-4">
            <h1 class="py-2">Start a Discussion</h1>
            <form action="' . $_SERVER["REQUEST_URI"] .'" method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Concern Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Keep your title as short as possible.</div>
                </div>
                <input type="hidden" name="sno" value="'. $_SESSION["sno"]. '">               
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Elaborate Your Concern</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
    </div>';
      }
      else{
        echo '
        <div class="container col-lg-8 my-5 d-flex justify-content-center">
            <div class="card border-0 shadow-sm text-center p-4" style="max-width: 600px; border-radius: 12px;">
                <div class="card-body">
                    <h2 class="fw-semibold text-danger"><i class="bi bi-info-circle-fill"></i> Login Required</h2>
                    <p class="lead text-muted mt-3">You need to be logged in to send a message.</p>
                    <button type="button" class="btn btn-danger btn-lg mt-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login Now
                    </button>  
               </div>
            </div>
        </div>
        
        <style>
            .card {
                animation: fadeIn 0.7s ease-in-out;
                background: #f8f9fa;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
        ';
           
      }
    ?>


    <div class="container mb-5 col-lg-8 ">
        <h1 class="py-2">Browse Questions</h1>
        <?php
            $limit = 5; // Number of questions per page
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id LIMIT $start, $limit";
            $result = mysqli_query($conn, $sql);

            $total_sql = "SELECT COUNT(*) FROM `threads` WHERE thread_cat_id = $id";
            $total_result = mysqli_query($conn, $total_sql);
            $total_rows = mysqli_fetch_array($total_result)[0];
            $total_pages = ceil($total_rows / $limit);

            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $thread_id = $row['thread_id'];
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_time = $row['timestamp'];
                $thread_user_id = $row['thread_user_id'];
                $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                
                echo '<div class="media d-flex align-items-start my-2">
                    <img src="images/user_default.jpeg" width="54px" class="mr-3" alt="...">
                    <div class="media-body ms-3 mb-1">'.
                        '<h5><a href="thread.php?threadid=' . $thread_id . '">' . $title . '</a></h5>
                        ' . $desc . '
                    </div>'.'<p class="fw-bold my-0 ms-auto">'. $row2['user_email'] . ' <small class="text-muted">' . date("F j, Y, g:i A", strtotime($thread_time)) . '</small></p>'.
                '</div>';
            }

            if ($noResult) {
                echo '<div class="card bg-light my-3">
                <div class="card-body">
                <h2 class="display-4">No thread Found</h2>
                <p class="lead">Be the first person to ask a question.</p>
                </div>
            </div>';
            }

            // Pagination Buttons
            if ($total_pages > 1) {
                echo '<div class="d-flex justify-content-between mt-3">';
                if ($page > 1) {
                    echo '<a href="?catid=' . $id . '&page=' . ($page - 1) . '" class="btn btn-success"><<< Previous</a>';
                }
                if ($page < $total_pages) {
                    echo '<a href="?catid=' . $id . '&page=' . ($page + 1) . '" class="btn btn-success ms-auto">Next >>></a>';
                }
                echo '</div>';
            }
        ?>
    </div>

    <?php include 'partials/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>