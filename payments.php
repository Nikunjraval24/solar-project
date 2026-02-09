<?php
include("db.php");

if(isset($_POST['pay_now'])){

  $customer_name = $_POST['customer_name'];
  $email         = $_POST['email'];
  $mobile        = $_POST['mobile'];
  $address       = $_POST['address'];
  $product_name  = $_POST['product_name'];
  $amount        = $_POST['amount'];
  $payment_method= $_POST['payment_method'];

  $sql = "INSERT INTO payments 
  (customer_name,email,mobile,address,product_name,amount,payment_method,payment_status)
  VALUES 
  ('$customer_name','$email','$mobile','$address','$product_name','$amount','$payment_method','Pending')";

  if(mysqli_query($conn,$sql)){
    header("Location: thank_you.php");
    exit();
  }else{
    echo "DB Error: " . mysqli_error($conn);
  }
}
?>
