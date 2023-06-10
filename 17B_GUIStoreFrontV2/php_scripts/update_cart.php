<?php
session_start();
include '../db_connection.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update_cart'])) {
    // Connect to the database
    $conn = OpenCon();

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if ($quantity > 0) {
        // Prepare an SQL statement to update the quantity of the item in the user's cart
        $stmt = $conn->prepare("UPDATE Cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param('iii', $quantity, $user_id, $product_id);
    } else {
        // Prepare an SQL statement to remove the item from the user's cart
        $stmt = $conn->prepare("DELETE FROM Cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param('ii', $user_id, $product_id);
    }

    // Execute the statement
    $stmt->execute();

    // Close the database connection
    CloseCon($conn);
}

// Redirect back to the shopping cart page
header('Location: ../shopping_cart.php');
?>
