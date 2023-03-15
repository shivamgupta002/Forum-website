<?php
$showError= "false";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        include'dbconnect.php';
    $user_email=$_POST['signupEmail'];
    $pass=$_POST['signupPassword'];
    $cpass=$_POST['signupcPassword'];

    //check whether email is exit or not
    $exitsql="select * from `users` where user_email='$user_email'";
    $result=mysqli_query($conn,$exitsql);
    $numRows=mysqli_num_rows($result);
    if($numRows>0){
        $showError="Email is already exits";
    }
    else{
        if($pass==$cpass){
            $hash=password_hash($pass,PASSWORD_DEFAULT);
            $sql="INSERT INTO `users` ( `user_email`, `user_pass`) VALUES ('$user_email', '$hash')";
            $result=mysqli_query($conn,$sql);
            if($result){
                $showalert=true;
                header("location:/project-1/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError="Password does\'t match";
        }
    }
    
    header("location:/project-1/index.php?signupsuccess=false&error=$showError");
}
?>