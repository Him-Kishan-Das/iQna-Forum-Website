<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to iQna - Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        #ques {
            min-height: 290px;
        }

        .pinkish-grey {
            background-color: #e8e1fc;
        }
    </style>
</head>

<body>
    <?php include './partials/_dbconnect.php' ?>
    <?php include './partials/_header.php' ?>

    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row["category_name"];
        $catdesc = $row["category_description"];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        //insert thread into database
        $th_title = $_POST['title'];
        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);

        $th_desc = $_POST['desc'];
        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc);

        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Question is added. Please wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }

    ?>


    <!-- Jumbotron starts here -->
    <div class="container my-2 pinkish-grey">
        <div class="jumbotron p-2">
            <h1 class="display-4">Welcome to <?php echo "$catname"; ?> forums</h1>
            <p class="lead"><?php echo "$catdesc"; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each other. No Spam / Advertising / Self-promotion is not allowed. Do not post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post questions. Do not PM users asking for help. Remain respectful of other members at all times.</p>
            <p class="lead">
                <a class="btn btn-success" href="#" role="button">Learn More</a>
            </p>
        </div>
    </div>

    <?php

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']== true){
    echo '<div class="container mb-4">
        <h1 class="py-1 mt-4 fw-bold">Ask a Question</h1>
        <form action="'. $_SERVER["REQUEST_URI"] .'" method="POST">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label fs-3 text">Problem title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter your question">
                <div id="emailHelp" class="form-text">Keep your question as crisp as possible.</div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label fs-3 text">Elaborate your Problem
                </label>
                <textarea class="form-control"  id="desc" name="desc" rows="3"></textarea>
                <input type="hidden" name="sno" value="' . $_SESSION["sno"] . '"/>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    }
    else{
        echo '<div class="container">
        <h1 class="py-1 mt-4 fw-bold">Ask a Question</h1>
        <p class="lead">You are not Logged in. Please log in to Ask a Question.</p>
    </div>';
    }
    

?>


    <div class="container py-3" id="ques">
        <h2 class="fw-bold">Browse Questions</h2>

        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row["thread_id"];
            $title = $row["thread_title"];
            $desc = $row["thread_desc"];
            $thread_time = $row["timestamp"];
            $thread_user_id = $row["thread_user_id"];
            $sql2 = "SELECT user_email FROM `user` where sno = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            

            echo '<div class="container d-flex pt-2">
            <div class="media-top">
                <img src="./img/userdefault.png" width="40px" alt="...">
            </div>
            <div class="media-body px-3">
            <p class="fw-bold my-0">'. $row2['user_email'] .' at ' . $thread_time . '</p>
                <h5 class="fw-bold "><a class="text-dark text-decoration-none" href="thread.php?threadid=' . $id . '">' . $title . '</a></h5>
                <p>' . $desc . '</p>
            </div>
            </div>';
        }
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid pinkish-grey pt-3 pb-3 mt-3 text-danger">
            <div class="container">
              <p class="display-4">No Questions Found.</p>
              <hr>
              <p class="lead">Be the first person to ask a question.</p>
            </div>
          </div>';
        }
        ?>


    </div>





    <?php include './partials/_footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>


</body>

</html>