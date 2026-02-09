<?php
include "db.php";

/* 🔴 Connection check */
if(!$conn){
    die("Database connection failed: " . mysqli_connect_error());
}

$success = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){

    /* 🔴 Check all POST values */
    if(
        isset($_POST['name'], $_POST['email'], $_POST['product'], $_POST['issue'], $_POST['complaint'])
    ){

        $name = $_POST['name'];
        $email = $_POST['email'];
        $product = $_POST['product'];
        $issue = $_POST['issue'];
        $complaint = $_POST['complaint'];

        /* 🔴 Insert query exactly table order ma */
        $sql = "INSERT INTO complaints
                (customer_name, email, product, issue, complaint)
                VALUES
                ('$name','$email','$product','$issue','$complaint')";

        if(mysqli_query($conn, $sql)){
            $success = true;
        } else {
            echo "Insert Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customer Complaint</title>

<style>
body{
    font-family:'Segoe UI',sans-serif;
    background:#f4f6f8;
    margin:0;
}
.header{
    background:linear-gradient(135deg,#fbbc05,#34a853);
    padding:20px;
    color:white;
    font-size:22px;
}
.container{
    max-width:700px;
    margin:40px auto;
    background:white;
    padding:35px;
    border-radius:18px;
    box-shadow:0 15px 40px rgba(0,0,0,0.1);
}
label{
    font-weight:600;
    margin-top:18px;
    display:block;
}
input, select, textarea{
    width:100%;
    padding:14px;
    margin-top:8px;
    border-radius:12px;
    border:1px solid #ddd;
    font-size:15px;
}
textarea{resize:none;height:120px;}
button{
    margin-top:25px;
    width:100%;
    padding:15px;
    background:#34a853;
    color:white;
    border:none;
    border-radius:30px;
    font-size:17px;
    cursor:pointer;
}
.success{
    margin-top:20px;
    background:#e6f4ea;
    padding:15px;
    border-radius:12px;
    color:#0f9d58;
    text-align:center;
}
</style>
</head>

<body>

<div class="header">📩 Customer Complaint Form</div>

<div class="container">

<?php if($success){ ?>
<div class="success">
    ✅ Your complaint has been submitted successfully.<br>
    Our support team will contact you soon.
</div>
<?php } ?>

<form method="POST">
        
    <label>Your Name</label>
    <input type="text" name="name" required placeholder="Enter your full name">

    <label>Email Address</label>
    <input type="email" name="email" required placeholder="Enter your email">

    <label>Product Name</label>
    <select name="product" required>
        <option value="">Select Product</option>
        <option>Mono Solar Panel</option>
        <option>Poly Solar Panel</option>
        <option>Thin Film Panel</option>
        <option>Off Grid Solar Panel</option>
        <option>Bifacial Solar Panel</option>
        <option>Smart Solar Panel</option>
    </select>

    <label>Complaint Type</label>
    <select name="issue" required>
        <option value="">Select Issue</option>
        <option>Installation Problem</option>
        <option>Low Power Output</option>
        <option>Panel Damage</option>
        <option>Billing Issue</option>
        <option>Other</option>
    </select>

    <label>Your Complaint</label>
    <textarea name="complaint" required placeholder="Describe your issue..."></textarea>

    <button type="submit">Submit Complaint</button>
</form>

</div>

</body>
</html>
