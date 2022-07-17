<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome to iQna - Coding Forums</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
  <?php include './partials/_dbconnect.php' ?>
  <?php include './partials/_header.php' ?>
  <!-- Slider starts here -->
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="./img/dfsdf.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="./img/Slider2.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="./img/Slider3.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Category Container Starts here -->
  <div class="container my-2">
    <h2 class="text-center">iQna - Browse Categories</h2>
    <div class="row my-4">
      <!-- Fetch all the Categories -->

     <!-- we can use this url https://source.unsplash.com/400x300/?coding,' . $cat . ' in src of image if we wantto connect with api -->
      <?php 
       $sql = "SELECT * FROM `categories`";
       $result = mysqli_query($conn, $sql);
      // <!-- use a for looop to iterate through Categories -->
       while($row = mysqli_fetch_assoc($result)){
          // echo $row['category_id'];
          // echo $row['category_name'];
          $id = $row['category_id'];
          $cat = $row['category_name'];
          $desc = $row['category_description'];
          echo '<div class="col-md-4 my-4">
          <div class="card" style="width: 18rem;">
            <img src="img/' . $cat . '.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><a href="./threadlist.php?catid=' . $id . '">' . $cat . '</a></h5>
              <p class="card-text">' . substr($desc, 0, 130) .'...</p>
              <a href="./threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
            </div>
          </div>
        </div>';

       }

      ?>


      

    </div>
  </div>


  <?php include './partials/_footer.php' ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>


</body>

</html>