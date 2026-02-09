<?php
session_start();

$admin_user = "admin";
$admin_pass = "12345";

$username = $_POST['username'];
$password = $_POST['password'];

if($username == $admin_user && $password == $admin_pass){
    $_SESSION['admin'] = true;
    header("Location: dashboard.php");
} else {
    header("Location: login.php?error=1");
}
