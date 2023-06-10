<?php

session_start();
include '../db_connection.php';

$conn = OpenCon();

if (isset($_POST['add_item']) && $_POST['brand'] != '' && $_POST['model']!='' 
        && $_POST['price'] != '') {
    // Retrieve the values from the form submission
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Insert the item into the inventory table
    $sql = "INSERT INTO inventory (brand, model, price, stock) VALUES ('$brand', '$model', '$price', '$stock')";
    if ($conn->query($sql) === TRUE) {
        echo "<h3>Item added to inventory successfully</h3>";
        echo "<br>";
    } else {
        echo "<h3>Error adding item to inventory: " . $conn->error . "</h3>";
        echo "<br>";
    }

    // Close the database connection
    CloseCon($conn);
} else {
    echo "<h1>Missing Fields!</h1>";
}
echo "<button onclick=location.href='../add_inventory.php'>Return</button>";
