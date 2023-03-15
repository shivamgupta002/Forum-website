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

</head>

<body>
    <!-- ------------------------------------------Navbar----------------------------------- -->
    <div class="navbar mb-5">
        <?php
        include './component/navbar.php';
        include './component/dbconnect.php';
        ?>
    </div>
    <!-- --------------------------------------PHP-------------------------------------- -->
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>
    <!-- ---------------------- FORM SUBMIT--------------------------------- -->
    <?php
    $showalert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);

        $th_desc = str_replace(">", "&gt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc);

        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`) VALUES ( '$th_title', '$th_desc', '$id', '$sno' )";
        $result = mysqli_query($conn, $sql);
        $showalert = true;
        if ($showalert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> You question will be submitted ! wait for the community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>
    <!-- ------------------------------- About Forum   ----------------------------------------- -->
    <div class="container">
        <div class="container-fluid py-4 bg-dark text-white">
            <h1 class=" fw-bold text-center">Welcome to <?php echo "$catname"; ?> forum</h1>
            <p class="fs-5 text-center"><?php echo "$catdesc"; ?>
            </p>
            <button class="btn btn-success btn-lg mx-2" type="button">Browse</button>
        </div>
    </div>
    <!-- ------------------------------  Disucssion  --------------------------------------------------- -->
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '<div class="container">
            <h1 class="py-2">Start a Discussion</h1> 

<form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Problem Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as
                        possible</small>
                </div>
                <input type="hidden"name="sno" value="' . $_SESSION["sno"] . '">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Ellaborate Your Concern</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>';
    } else {
        echo '
        <div class="container">
        <h1 class="py-2">Start a Discussion</h1> 
           <p class="lead">You are not logged in. Please login to be able to start a Discussion</p>
        </div>
        ';
    }
    ?>
    <!-- ------------------------------  Question  --------------------------------------------------- -->
    <div class="container my-3">
        <h1 class="pb-3">Browse question</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noresult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noresult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $time = $row['time'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo '<div class="d-flex mb-3">
            <div class="flex-shrink-0">
                <img src="./img/de-user.jpg" alt="default user" width="55px">
            </div>
            <div class="flex-grow-1 ms-3">
                <p class="fw-bold my-0">' . $row2['user_email'] . ' at ' . $time . '</p>
                <h5 ><a class="text-dark text-decoration-none" href="/project-1/thread.php?threadid=' . $id . '">' . $title . '</a></h5>
                <p >' . $desc . '
                </p>
            </div>
        </div>';
        }
        if ($noresult) {
            echo '
            <div class="col-md-12">
        <div class="h-100 p-3 bg-light border rounded-3 text-center">
          <h2>No Questions Yet</h2>
          <p>Be the first one to ask a question.</p>
        </div>
      </div>';
        }

        ?>









        <!--=-------------------- Bootstrap Bundle with Popper ------------------------->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

</body>

</html>