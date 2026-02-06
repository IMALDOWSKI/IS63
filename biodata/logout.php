<?php 
session_start();
session_destroy();
setcookie("coo_email",$email,time()-(3600*24*30),"/");
header("location:login.php");
?>