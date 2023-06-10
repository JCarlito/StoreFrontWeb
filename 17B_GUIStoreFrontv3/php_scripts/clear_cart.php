<?php
session_start();
include '../db_connection.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$conn = OpenCon();

// Prepare an SQL statement to remove all items from the user's cart
$stmt = $conn->prepare("DELETE FROM Cart WHERE user_id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);

// Execute the statement
$stmt->execute();

// Close the database connection
CloseCon($conn);

// Redirect back to the shopping cart page
header('Location: ../shopping_cart.php');
?>
