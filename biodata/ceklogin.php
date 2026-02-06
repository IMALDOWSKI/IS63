<?php 
session_start();
if(!isset($_SESSION['ses_email']) AND !isset($_COOKIE['coo_email'])){
    header("location:http://localhost/IS63/biodata/login.php");
}
?>