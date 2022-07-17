<?php

session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/forum">iQna</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Top Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

                $sql = "SELECT `category_name`, `category_id` FROM `categories` LIMIT 6";
                $result = mysqli_query($conn, $sql);
                $numRows = mysqli_num_rows($result);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li><a class="dropdown-item" href="./threadlist.php?catid=' . $row['category_id'] . '">' . $row['category_name'] . '</a></li>';
                }

                echo '</ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./contact.php">Contact</a>
                </li>
            </ul>
            <div class="mx-1">';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '<form class="d-flex" role="search" action="search.php" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn mx-1 btn-success" type="submit">Search</button>
                <p class=" my-0 mx-2 py-2 text-light">' . $_SESSION['useremail'] . '</p>
                <a href="/forum/partials/_logout.php" role="button" class="btn btn-outline-success mx-2" >LogOut</a>
            </form>';
} else {
    echo '<form class="d-flex" role="search" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                    <button class="btn mx-1 btn-success" type="submit">Search</button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-outline-success mx-1" >Login</button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#signupModal" class="btn btn-outline-success mx-2" >SignUp</button>
                    </form>';
}

echo '</div>

        </div>
    </div>
</nav>';

include './partials/_loginModal.php';
include './partials/_signupModal.php';

if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
    echo '<div class="my-0 alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> You scan now login.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
