<?php
session_start();

echo"Please wait a moment";
session_destroy();
header('location:/project-1');
?>