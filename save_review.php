<?php
include("db.php"); // DB connection

if(isset($_POST['product_id'], $_POST['name'], $_POST['rating'], $_POST['comment'])){

    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $name       = mysqli_real_escape_string($conn, $_POST['name']);
    $rating     = mysqli_real_escape_string($conn, $_POST['rating']);
    $comment    = mysqli_real_escape_string($conn, $_POST['comment']);

    $sql = "INSERT INTO product_reviews 
            (product_id, customer_name, rating, review_text, status) 
            VALUES 
            ('$product_id', '$name', '$rating', '$comment', 'pending')";

    if(mysqli_query($conn, $sql)){
        echo "success";
    }else{
        echo "db_error";
    }

}else{
    echo "invalid";
}
?>
