<?php
session_start();
include '../db_connection.php';

$conn = OpenCon();

if (isset($_POST['edit_item']) && floatval($_POST['price']) > 0 && intval($_POST['stock']) >= 0) {
    $id = $_POST['product_id'];
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    $stmt = $conn->prepare("UPDATE inventory SET price=?, stock=? WHERE product_id=?");
    $stmt->bind_param('dii', $price, $stock, $id);
    if ($stmt->execute()) {
        echo "Item updated successfully";
    } else {
        echo "Error updating item: " . $stmt->error;
    }
} else {
    echo "Invalid form submission";
}
// Close the database connection
CloseCon($conn);
// Redirect back to the shopping cart page
header('Location: ../edit_inventory.php');
?>
