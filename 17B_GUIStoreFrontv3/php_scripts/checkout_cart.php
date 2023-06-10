<?php
session_start();
include '../db_connection.php';

// Connect to the database
$conn = OpenCon();

// Fetch the user's cart
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$cart = $stmt->get_result();

// Begin a transaction
$conn->begin_transaction();

// Insert a new row in the Orders table
$stmt = $conn->prepare("INSERT INTO orders (user_id, date) VALUES (?, NOW())");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();

// Get the ID of the new order
$order_id = $conn->insert_id;

$total_order = 0;

// For each item in the cart
while ($item = $cart->fetch_assoc()) {
    // Get the current price of the item from the Inventory table
    $stmt = $conn->prepare("SELECT price FROM inventory WHERE product_id = ?");
    $stmt->bind_param('i', $item['product_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $price_row = $result->fetch_assoc();
    $unit_price = $price_row['price'];

    // Calculate the total price for this item
    $total_price = $unit_price * $item['quantity'];
    $total_order += $total_price;

    // Insert a new row in the OrderDetails table
    $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('iidd', $order_id, $item['product_id'], $item['quantity'], $unit_price);
    $stmt->execute();

    // Decrease the inventory stock
    $stmt = $conn->prepare("UPDATE inventory SET stock = stock - ? WHERE product_id = ?");
    $stmt->bind_param('ii', $item['quantity'], $item['product_id']);
    $stmt->execute();
}

// Update total in the Orders table
$stmt = $conn->prepare("UPDATE orders SET total = ? WHERE order_id = ?");
$stmt->bind_param('di', $total_order, $order_id);
$stmt->execute();

// Empty the user's cart
$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();

// Commit the transaction
$conn->commit();

// Close the database connection
CloseCon($conn);

// Redirect to a confirmation page
header('Location: ../checkout_success.php');
exit();
?>
