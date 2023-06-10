<?php

session_start();
include '../db_connection.php';

$conn = OpenCon();

if (isset($_POST['add_item'])) {
    // Retrieve the values from the form submission
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image'];
    $uploadDir = 'images/';

    if ($image['error'] !== 0) {
        die('An error occurred during image upload');
    }

    // Ensure the file is an image
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $image['tmp_name']);
    if (strpos($mime, 'image') === false) {
        die('Invalid file type uploaded.');
    }

    // Generate a unique file name and move the file from tmp dir to your desired directory
    $fileName = uniqid() . "-" . basename($image["name"]);
    $targetFile = '../' . $uploadDir . $fileName;
    if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
        die('Error moving uploaded file');
    }

    // Insert the item into the inventory table
    $stmt = $conn->prepare("INSERT INTO inventory (brand, model, price, stock, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdis', $brand, $model, $price, $stock, $targetFile);
    if ($stmt->execute()) {
        echo "<h3>Item added to inventory successfully</h3>";
        echo "<br>";
    } else {
        echo "<h3>Error adding item to inventory: " . $stmt->error . "</h3>";
        echo "<br>";
    }

    // Close the database connection
    CloseCon($conn);
} else {
    echo "<h1>Missing Fields!</h1>";
}
echo "<button onclick=location.href='../add_inventory.php'>Return</button>";
