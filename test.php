<?php
// test.php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $customer_name   = $_POST['customer_name'] ?? '';
    $email           = $_POST['email'] ?? '';
    $mobile          = $_POST['mobile'] ?? '';
    $address         = $_POST['address'] ?? '';
    $product_name    = $_POST['product_name'] ?? '';
    $amount          = $_POST['amount'] ?? '';
    $payment_method  = $_POST['payment_method'] ?? 'Online';
    $payment_status  = $_POST['payment_status'] ?? 'Paid';

    if (
        empty($customer_name) || empty($email) || empty($mobile) ||
        empty($address) || empty($product_name) || empty($amount)
    ) {
        echo "ERROR: Missing fields";
        exit;
    }

    $sql = "INSERT INTO payments 
        (customer_name, email, mobile, address, product_name, amount, payment_method, payment_status) 
        VALUES 
        ('$customer_name', '$email', '$mobile', '$address', '$product_name', '$amount', '$payment_method', '$payment_status')";

    if (mysqli_query($conn, $sql)) {
        echo "SUCCESS";
    } else {
        echo "DB ERROR: " . mysqli_error($conn);
    }

} else {
    echo "INVALID REQUEST";
}
?>
