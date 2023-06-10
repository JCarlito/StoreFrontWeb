<?php

session_start();
include '../db_connection.php';

$conn = OpenCon();

if (isset($_POST['edit_item']) && floatval($_POST['price']) > 0 && intval($_POST['stock']) >= 0) {
    $id = $_POST['id'];
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    $sql = "UPDATE inventory SET price='$price', stock='$stock' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Item updated successfully";
    } else {
        echo "Error updating item: " . $conn->error;
    }
} else {
    echo "Invalid form submission";
}
// Close the database connection
CloseCon($conn);
echo "<br>";
echo "<button onclick=location.href='../edit_inventory.php'>Return</button>";
