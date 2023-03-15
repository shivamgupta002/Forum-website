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
    <div class="navbar mb-4">
        <?php
        include './component/navbar.php';
        include './component/dbconnect.php';
        ?>
    </div>
    <!-- --------------------------------------PHP-------------------------------------- -->
    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        //Query to find the original posted person
        $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        $posted_by=$row2['user_email'];
    }
    ?>
    <!-- --------------------------------------------------- -->
    <?php
    $showalert=false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //Insert into comment
        $sno=$_POST['sno'];
        $comment = $_POST['comment'];
        $comment=str_replace("<","&lt;",$comment);
        $comment=str_replace("<","&gt;",$comment);
        $sql="INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`) VALUES ( '$comment', '$id', '$sno')";
        $result = mysqli_query($conn, $sql);
        $showalert=true;
        if($showalert){
            echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> You commment hs been submitted !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>
    <!-- ------------------------------- About Forum   ----------------------------------------- -->
    <div class="container ">
        <div class="container-fluid py-5 bg-dark text-white">
            <h1 class=" fw-bold text-center">
                <?php echo $title; ?>
            </h1>
            <p class="fs-5 text-center">
                <?php echo $desc; ?>
            </p>
            <b>Posted by</b><em> <?php echo $posted_by;?></em>

            <!-- <button class="btn btn-success btn-lg mx-3" type="button">Browse</button> -->
        </div>
    </div>
    
    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){ 
    echo '<div class="container">
        <h1 class="py-2">Post a Comment</h1> 
        <form action= "'. $_SERVER['REQUEST_URI'] . '" method="post"> 
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
<input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form> 
    </div>';
    }
    else{
        echo '   
        <div class="container">
        <h1 class="py-2">Post a Comment</h1> 
           <p class="lead">You are not logged in. Please login to be able to post comments.</p>
        </div>
        ';
    }
    ?>
   
    <!-- ------------------------------  Question  --------------------------------------------------- -->
    <div class="container my-3">
        <h1 class="pb-3">Discussion</h1>
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        $noresult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noresult = false;
            $time = $row['comment_time'];
            $id = $row['comment_id'];
            $desc = $row['comment_content'];
            $thread_user_id = $row['comment_by'];

            $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);

            echo '<div class="d-flex mb-3">
            <div class="flex-shrink-0">
                <img src="./img/de-user.jpg" alt="default user" width="55px">
            </div>
            <div class="flex-grow-1 ms-3">
            <p class="fw-bold my-0">'.$row2['user_email'].' at ' . $time . '</p>
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