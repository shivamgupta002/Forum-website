<?php
include 'component/dbconnect.php';
session_start();

echo '
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">iDiscuss</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             Top Category
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                $sql = "SELECT category_name,category_id FROM `categories` LIMIT 3";// LImit set the no of category 
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '   <li><a class="dropdown-item" href="threadlist.php?catid=' .$row['category_id'] . '">' . $row['category_name'] . '</a></li>';
                }
echo '   </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php"  >Contact Us</a>
            </li>
          </ul>';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  echo '
     <form class="d-flex mx-3">
        
        </form>
        <p class="text-light my-0 mx-2">Welcome ' . $_SESSION['useremail'] . '</p>
        <a href="./component/logout.php"> <button type="button" class="btn btn-outline-success ml-2">
        Logout
        </button></a>';
} else {
  echo '
          <button type="button" class="btn btn-outline-success ml-2 " data-bs-toggle="modal" data-bs-target="#loginModal">
          Login
          </button>
          <button type="button" class="btn btn-outline-success  mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            SignUp
          </button>    
          ';
}


echo '</div>
      </div>
    </nav>';
?>
<?php
include 'component/signup.php';
include 'component/login.php';
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
  echo '
    <div class="alert alert-success alert-dismissible fade show my-0  w-100" role="alert">
    <strong>Congrulation!</strong> You are signup successfully. You can login now.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
 
  </div>';
} else if ($_GET['signupsuccess'] == "false") {
  echo '
    <div class="alert alert-danger alert-dismissible fade show my-0 w-100" role="alert">
    <strong>Failed!</strong> Your e-mail id already been used.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
 
  </div>';
} else if (isset($_GET['loginsuccess']) && $_GET['loginsuccess'] == "true") {
  echo '
    <div class="alert alert-success alert-dismissible fade show my-0 w-100" role="alert">
    <strong>Congrulation!</strong> You are login successfully. You can post now.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
 
  </div>';
} else if (isset($_GET['loginsuccess']) && $_GET['loginsuccess'] == "false") {
  echo '
    <div class="alert alert-danger alert-dismissible fade show my-0  w-100" role="alert">
    <strong>Failed!</strong>Your password is wrong. You are\'t signup successfully. 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
 
  </div>';
}
?>