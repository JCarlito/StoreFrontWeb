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
    </head>
    <body>
        <h1>Add Inventory Item</h1>
        <form action="php_scripts/add_item.php" method="post" enctype="multipart/form-data">
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required>

            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required>

            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required>

            <label for="stock">Stock:</label>
            <select id="stock" name="stock">
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
