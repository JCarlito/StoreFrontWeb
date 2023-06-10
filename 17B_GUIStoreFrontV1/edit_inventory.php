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
            </tr>
            <?php
            $conn = OpenCon();
            $sql = "SELECT * FROM inventory";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["brand"] . "</td>";
                    echo "<td>" . $row["model"] . "</td>";
                    echo "<td>";
                    echo "<form action='php_scripts/edit_item.php' method='post'>";
                    echo "<input type='hidden' name='product_id' value='" . $row["product_id"] . "'>";
                    echo "<input type='text' name='price' value='" . $row["price"] . "'>";
                    echo "<input type='text' name='stock' value='". $row['stock'] . "'>";
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