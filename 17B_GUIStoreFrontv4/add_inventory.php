<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Add Inventory</title>
    <style>
        /* CSS styles for the page layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            box-sizing: border-box;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        select {
            width: 94%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .stock-select {
            width: 45px;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* CSS styles for the home button */
        .home-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .home-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <!-- Home Button -->
    <a class="home-button" href="admin.php">Home</a>

    <h1>Add Inventory Item</h1>
    <form action="php_scripts/add_item.php" method="post" enctype="multipart/form-data">
        <label for="brand">Brand:</label>
        <input type="text" id="brand" name="brand" required>

        <label for="model">Model:</label>
        <input type="text" id="model" name="model" required>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>

        <label for="stock">Stock:</label>
        <select id="stock" name="stock" class="stock-select">
            <?php
            $max = 100;
            for ($i = 1; $i <= $max; $i++) {
                echo "<option value=\"$i\">$i</option>";
            }
            ?>
        </select>

        <label for="image">Shoe Image:</label><br>
        <input type="file" id="image" name="image" required><br>
        <br>
        <input type="submit" value="Add Item" name="add_item">
    </form>
</body>
</html>
