<?php
include("db.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $customer_name  = $_POST['customer_name'] ?? '';
  $email          = $_POST['email'] ?? '';
  $mobile         = $_POST['mobile'] ?? '';
  $address        = $_POST['address'] ?? '';
  $product_name   = $_POST['product_name'] ?? '';
  $amount         = $_POST['amount'] ?? '';
  $payment_method = $_POST['payment_method'] ?? 'Online';
  $payment_status = "Pending";

  if($customer_name && $email && $mobile && $address && $product_name && $amount){

    $sql = "INSERT INTO payments 
    (customer_name,email,mobile,address,product_name,amount,payment_method,payment_status)
    VALUES 
    ('$customer_name','$email','$mobile','$address','$product_name','$amount','$payment_method','$payment_status')";

    if(mysqli_query($conn,$sql)){
      echo "success";
    }else{
      echo "DB Error: " . mysqli_error($conn);
    }

  }else{
    echo "Missing Fields";
  }
}
?>
