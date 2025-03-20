<?php

session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/forum">CodeForum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/forum">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Top Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="categoryDropdown">';

$sql = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['category_id'];
    $cat = $row['category_name'];
    echo '<li><a class="dropdown-item" href="threadlist.php?catid=' . $id . '">' . $cat . '</a></li>';
}

echo '</ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php" tabindex="-1">Contact</a>
        </li>
      </ul>';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '<form class="d-flex align-items-center" role="search" method="get" action="search.php">
                  <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-success me-2" type="submit">Search</button>
                  <p class="text-light mb-0">Welcome ' . $_SESSION['useremail'] . ' </p>
                  <a href="partials/_logout.php" class="btn btn-outline-success ml-2 mx-2">Logout</a>
              </form>';
} else {
    echo '<form class="d-flex align-items-center" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success me-2" type="submit">Search</button>
            </form>
            <button type="button" class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
              Login
            </button>
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupModal">
            Signup
            </button>';
}

echo '</div>
        </div>
      </nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>Success!</strong> Your account is now created and you can login.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "false") {
    $showError = $_GET['error'];
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
    <strong>Error!</strong> ' . $showError . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
?>
