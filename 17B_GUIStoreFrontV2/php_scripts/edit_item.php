<?php

session_start();
include '../db_connection.php';

$conn = OpenCon();
if (isset($_POST['edit_item'])) {
    $id = $_POST['product_id'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $status = $_POST['status'];
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

    $stmt = $conn->prepare("UPDATE inventory SET brand=?, model=?, price=?, stock=?, status=?, image=? WHERE product_id=?");
    $stmt->bind_param('ssdiisi', $brand, $model, $price, $stock, $status, $targetFile, $id);
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
