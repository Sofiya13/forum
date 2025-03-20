<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>

<body>
    <?php include 'partials/_dbConnect.php'; ?>
    <?php include 'partials/_header.php'; ?>

    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];                                                            
        $thread_user_id = $row['thread_user_id'];                                                            
        $sql2 = "select user_email from `users` where sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
        if($method =='POST'){
            $comment = $_POST['comment'];
            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace(">", "&gt;", $comment);

            $sno = $_POST['sno'];
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
                if($showAlert){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your Comment has been added successfully. Please wait for community to respond.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                }
         }
?>

<div class="container col-lg-8 my-4">
    <div class="card bg-light forum-post p-3">
        <div class="card-body">
            <h1 class="display-4 "><?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="bi bi-chat-square-dots text-primary"></i> <strong>Stay Relevant to the Topic</strong> – Keep discussions focused and meaningful.</li>
                <li class="list-group-item"><i class="bi bi-shield-exclamation text-danger"></i> <strong>No Spamming or Flooding</strong> – Avoid excessive or repetitive messages.</li>
                <li class="list-group-item"><i class="bi bi-lightbulb text-warning"></i> <strong>Share Accurate & Helpful Information</strong> – Contribute valuable insights and verified facts.</li>
                <li class="list-group-item"><i class="bi bi-megaphone text-success"></i> <strong>No Self-Promotion or Advertising</strong> – Unsolicited marketing is not allowed.</li>
            </ul>
            <p class="mt-3"><i class="bi bi-person-circle text-secondary"></i> <strong>Posted by:</strong> <b><i><?php echo $posted_by; ?></i></b></p>
        </div>
    </div>
</div>

<style>
    /* Hover Effect for List Items */
    .list-group-item:hover {
        background-color: #f8f9fa; /* Light gray hover effect */
        transition: 0.3s ease-in-out;
    }

    /* Sticky Notice for Forum Posts */
    .forum-post {
        position: sticky;
        top: 20px;
        z-index: 1000;
    }
</style>

    <?php
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container col-lg-8 my-4">
        <h1 class="py-2">Post a Comment</h1>
        <form action="' . $_SERVER["REQUEST_URI"] .'" method="post">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Type Your Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'. $_SESSION["sno"]. '">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
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
        <h1 class="py-2">Discussion</h1>
        <?php
            $limit = 5; // Number of comments per page
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            $id = $_GET['threadid'];
            $sql = "SELECT * FROM `comments` WHERE thread_id = $id LIMIT $start, $limit";
            $result = mysqli_query($conn, $sql);

            $total_sql = "SELECT COUNT(*) FROM `comments` WHERE thread_id = $id";
            $total_result = mysqli_query($conn, $total_sql);
            $total_rows = mysqli_fetch_array($total_result)[0];
            $total_pages = ceil($total_rows / $limit);

            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $comment_id = $row['comment_id'];
                $content = $row['comment_content'];
                $thread_user_id = $row['comment_by'];
                
                $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                
                echo '<div class="media d-flex align-items-start ">
                    <img src="images/user_default.jpeg" width="54px" class="mr-3" alt="...">
                    <div class="media-body ms-3 mb-1">
                        <p class="fw-bold my-0">' . $row2['user_email'] . 
                        ' <small class="text-muted">' . date("F j, Y, g:i A", strtotime($row['comment_time'])) . '</small></p>
                        <p>' . $content . '</p>
                    </div>
                </div>';
            }

            if ($noResult) {
                echo '<div class="card bg-light my-3">
                <div class="card-body">
                <h2 class="display-4">No comment Found</h2>
                <p class="lead">Be the first person to comment.</p>
                </div>
            </div>';
            }

            // Pagination Buttons
            if ($total_pages > 1) {
                echo '<div class="d-flex justify-content-between mt-3">';
                if ($page > 1) {
                    echo '<a href="?threadid=' . $id . '&page=' . ($page - 1) . '" class="btn btn-success"><<< Previous</a>';
                }
                if ($page < $total_pages) {
                    echo '<a href="?threadid=' . $id . '&page=' . ($page + 1) . '" class="btn btn-success ms-auto">Next >>></a>';
                }
                echo '</div>';
            }
        ?>
    </div>



    <?php include 'partials/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>