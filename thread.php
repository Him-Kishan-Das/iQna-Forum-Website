<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to iQna - Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
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
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row["thread_title"];
        $desc = $row["thread_desc"];
        $thread_user_id = $row['thread_user_id'];

        $sql2 = "SELECT user_email FROM `user` where sno = '$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];
    }
    ?>
    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //insert thread into database
        $comment = $_POST['comment'];
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Comment has been added!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <!-- Jumbotron starts here -->
    <div class="container my-2 pinkish-grey">
        <div class="jumbotron p-2">
            <h1 class="display-4"> <?php echo "$title"; ?></h1>
            <p class="lead"><?php echo "$desc"; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each other. No Spam / Advertising / Self-promotion is not allowed. Do not post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post questions. Do not PM users asking for help. Remain respectful of other members at all times.</p>
            <p class="lead">
                Posted by: <b class=" fw-bold"> <?php echo $posted_by; ?></b>
            </p>
        </div>
    </div>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { 
        echo '<div class="container mb-4">
        <h1 class="py-1 mt-4 fw-bold">Post a Solution</h1>
        <form action="' . $_SERVER["REQUEST_URI"] . '" method="POST">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label fs-4 text">Type your Comment
                </label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="' . $_SESSION["sno"] . '"/>
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
     } else {
        echo '<div class="container">
        <h1 class="py-1 mt-4 fw-bold">Post a Solution</h1>
            <p class="lead">You are not logged in. Please Logged in to Post a Solution.</p>
        </div>';
    }

?> 


    <div class="container py-3" id="ques">
        <h2 class="fw-bold">Discussions</h2>

        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row["comment_id"];
            $content = $row["comment_content"];
            $comment_time = $row["comment_time"];
            $thread_user_id = $row["comment_by"];
            $sql2 = "SELECT user_email FROM `user` where sno = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo '<div class="container d-flex pt-2">
            <div class="media-top">
                <img src="./img/userdefault.png" width="40px" alt="...">
            </div>
            <div class="media-body px-3">
                <p class="fw-bold my-0">' . $row2['user_email'] . ' at ' . $comment_time . '</p>
                <p>' . $content . '</p>
            </div>
            </div>';
        }

        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid pinkish-grey pt-3 pb-3 mt-3">
            <div class="container">
              <p class="display-6">No-one Posted a Solution.</p>
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