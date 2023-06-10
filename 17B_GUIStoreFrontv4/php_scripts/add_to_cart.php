<?php
session_start();
include '../db_connection.php';

if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Connect to the database
    $conn = OpenCon();

    // Prepare an SQL statement to check if the product is already in the user's cart
    $stmt = $conn->prepare("SELECT * FROM Cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param('ii', $user_id, $product_id);

    // Execute the statement and get the result
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // The product is already in the user's cart, so update the quantity
        $stmt = $conn->prepare("UPDATE Cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param('iii', $quantity, $user_id, $product_id);
    } else {
        // The product is not in the user's cart, so add a new row
        $stmt = $conn->prepare("INSERT INTO Cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param('iii', $user_id, $product_id, $quantity);
    }

    // Execute the statement
    $stmt->execute();

    // Close the database connection
    CloseCon($conn);

    // Redirect back to the store front
    header('Location: ../store_front.php');
    exit();
}
