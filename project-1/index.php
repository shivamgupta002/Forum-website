<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>iDiscuss</title>
    <style>
        .carousel-inner {
            height: 550px;
        }

        .center-item {
            display: flex;
            flex-wrap: wrap;
            margin-left: 4rem;

        }
    </style>
</head>

<body>
    <!-- ------------------------------------------Navbar----------------------------------- -->
    
        <?php
        include './component/navbar.php';
        ?>
    <!-- --------------------------------------------------------------- -->
    <!-- https://source.unsplash.com/1600x900/?nature -->
    <!-- ------------------ Slider  ----------------------- -->
        
<div id="carouselExampleFade" class="carousel slide carousel-fade $carousel-transition-duration: .6s;" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./img/cr-1.webp" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./img/cr-2.webp" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./img/cr-3.webp" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    <!-- ----------------------------  categories------------------------------- -->
    <div class="container ">
        <h2 class="text-center my-3">iDiscuss-Categories</h2>
    </div>
    <div class="center-item">
        <?php
        include './component/dbconnect.php';
        $sql = "SELECT * FROM `categories`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['category_id'];
            $cat = $row['category_name'];
            $desc = $row['category_description'];
            //    echo"$a";
            echo '
                <div class="col-md-4 my-3 ">
                    <div class="card" style="width: 18rem;">
                    <img src="./img/card-' . $id . '.jpg"class="card-img-top" alt="' . $cat . ' img" height=200px>
                        <div class="card-body">
                            <h5 class="card-title"><a class="text-dark text-decoration-none" href="/project-1/threadlist.php?catid=' . $id . '">' . $cat . '</a></h5>
                            <p class="card-text">' . substr($desc, 0, 100) . "..." . '</p>
                            <a href="/project-1/threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                        </div>
                    </div>
                    </div>';
        }
        ?>
    </div>

    </div>

    <!-- -------------------------------------------Footer----------------------------------- -->
    <?php
    include './component/footer.php';
    ?>

    <!--=-------------------- Bootstrap Bundle with Popper ------------------------->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>