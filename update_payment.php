<?php
include("../db.php");

$id = $_GET['id'];
$status = $_GET['status'];

mysqli_query($conn, "UPDATE payments SET payment_status='$status' WHERE id='$id'");

header("Location: payments.php");
?>
