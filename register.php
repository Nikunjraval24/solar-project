<?php
include "db.php";

$name  = $_POST['name'];
$email = $_POST['email'];
$pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

// check email exists
$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($check) > 0){
    echo "exists";
    exit();
}

mysqli_query($conn, "INSERT INTO users(name,email,password)
VALUES('$name','$email','$pass')");

echo "success";
?>