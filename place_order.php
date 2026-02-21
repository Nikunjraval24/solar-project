<?php
header('Content-Type: text/html; charset=UTF-8');
include("db.php");

// Get POST data safely
$customer_name  = mysqli_real_escape_string($conn, $_POST['customer_name'] ?? '');
$email          = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$mobile         = mysqli_real_escape_string($conn, $_POST['mobile'] ?? '');
$address        = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
$items          = mysqli_real_escape_string($conn, $_POST['items'] ?? '[]');
$subtotal       = mysqli_real_escape_string($conn, $_POST['subtotal'] ?? 0);
$gst            = mysqli_real_escape_string($conn, $_POST['gst'] ?? 0);
$grand_total    = mysqli_real_escape_string($conn, $_POST['grand_total'] ?? 0);
$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method'] ?? '');

$order_status = 'Pending';

// Correct SQL (FIXED VARIABLE NAMES)
$sql = "INSERT INTO orders 
(customer_name, email, mobile, address, items, subtotal, gst, grand_total, payment_method, order_status) 
VALUES 
('$customer_name', '$email', '$mobile', '$address', '$items', '$subtotal', '$gst', '$grand_total', '$payment_method', '$order_status')";

if(mysqli_query($conn, $sql)){
  echo "success";
}else{
  echo "error";
  // For debugging (optional)
  // echo mysqli_error($conn);
}
?>
