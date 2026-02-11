<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}
include("../db.php");

$id = $_POST['id'];
$status = $_POST['order_status'];

mysqli_query($conn, "UPDATE orders SET order_status='$status' WHERE id='$id'");

header("Location: orders.php");
exit();
