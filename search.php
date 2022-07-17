<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to iQna - Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        #maincontainer {
            min-height: 83.15vh;
        }
        .pinkish-grey {
            background-color: #e8e1fc;
        }
    </style>
</head>

<body>
    <?php include './partials/_dbconnect.php' ?>
    <?php include './partials/_header.php' ?>




    <!-- Search Results -->
    <div class="container" id="maincontainer">
        <h1 class="py-1 mt-4 fw-bold">Search results for <em> "<?php echo $_GET['search']  ?>"</em></h1>

        <?php
        $noResults = true;
        $search = $_GET['search'];
        $sql = "SELECT * FROM threads WHERE MATCH(thread_title, thread_desc) AGAINST ('$search')";
        
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $noResults = false;
            $title = $row["thread_title"];
            $desc = $row["thread_desc"];
            $thread_id = $row["thread_id"];
            $url = "thread.php?threadid=". $thread_id;
            
            echo '<div class="result">
                    <h3><a href="' . $url . '" class="text-dark"> ' . $title . '</a></h3>
                    <p> ' . $desc . '</p>
                </div>';
        }

        if($noResults){
            echo '<div class="jumbotron jumbotron-fluid pinkish-grey pt-3 pb-3 mt-3 text-danger">
                        <div class="container">
                        <p class="display-6">No-one Results Found.</p>
                        <hr>
                        <p class="lead">Suggestions not found.</p>
                        </div>
                    </div>';
        }
        ?>

    </div>

    <?php include './partials/_footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>


</body>

</html>