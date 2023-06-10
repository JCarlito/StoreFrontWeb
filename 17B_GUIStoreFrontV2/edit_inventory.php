<?php
session_start();
include 'db_connection.php';
?>

<!DOCTYPE html>
<htm1> 
    <head>
        <title> Admin - Edit Inventory </title>
    </head>
    <body>
        <h1>Edit Inventory</h1>
        <table>
            <tr>
                <th>Brand</th> 
                <th>Name</th>
                <th>Price $</th>
                <th>Stock</th>
                <th>Image</th>
            </tr>
            <?php
            $conn = OpenCon();
            $sql = "SELECT * FROM inventory";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>";
                    echo "<form action='php_scripts/edit_item.php' method='post' enctype='multipart/form-data'>";
                    echo "<input type='hidden' name='product_id' value='" . $row["product_id"] . "'>";
                    echo "<input type='text' name='brand' value='" . $row["brand"] . "'>";
                    echo "<input type='text' name='model' value='" . $row["model"] . "'>";
                    echo "<input type='text' name='price' value='" . $row["price"] . "'>";
                    echo "<input type='text' name='stock' value='" . $row['stock'] . "'>";
                    echo "<input type='file' name='image'>";
                    echo "<label><input type='radio' name='status' value='1' " . ($row['status'] == 1 ? 'checked' : '') . ">Activate</label>";
                    echo "<label><input type='radio' name='status' value='0' " . ($row['status'] == 0 ? 'checked' : '') . ">Deactivate</label>";
                    echo "<input type='submit' value='Edit Item' name='edit_item'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "NO INVENTORY!";
            }
            ?>
        </table>
    </body>
</html>