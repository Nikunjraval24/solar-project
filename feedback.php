<?php
// database connection
$conn = mysqli_connect("localhost", "root", "", "solar_project");

if (!$conn) {
    die("Database connection failed");
}

// form data receive
$name    = $_POST['name'];
$email   = $_POST['email'];
$rating  = $_POST['rating'];
$message = $_POST['message'];

// insert query
$sql = "INSERT INTO feedback (name, email, rating, message)
        VALUES ('$name', '$email', '$rating', '$message')";

if (mysqli_query($conn, $sql)) {

    echo "<script>
        alert('Thank you! Your review submitted successfully.');
        window.location.href='index.html';
    </script>";

} else {
    echo "Error: Data not inserted";
}

mysqli_close($conn);
?>
