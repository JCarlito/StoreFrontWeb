<!DOCTYPE html>
<htm1> 
    <head>
        <title> Shoe Odyssey </title>
    </head>
    <body>
        <table>
            <tr>
                <th>Brand</th> 
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
            <?php
            session_start();
            include 'db_connection.php';
            include 'cart.php';

            $cart = new Cart();

            $conn = OpenCon();
            $sql = "SELECT * FROM inventory";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["brand"] . "</td>";
                    echo "<td>" . $row["model"] . "</td>";
                    echo "<td>$" . $row["price"] . "</td>";
                    echo "<td>" . $row["stock"] . "</td>";
                    echo "<td>";
                    echo "<form action='php_scripts/add_to_cart.php' method='post'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<input type='hidden' name='brand' value='" . $row["brand"] . "'>";
                    echo "<input type='hidden' name='model' value='" . $row["model"] . "'>";
                    echo "<input type='hidden' name='price' value='" . $row["price"] . "'>";
                    echo "<input type='hidden' name='stock' value='1'>";
                    echo "<input type='submit' value='Add to Cart'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "NO INVENTORY!";
            }
            CloseCon($conn);
            ?>
        </table>
        <button onclick=location.href='shopping_cart.php'>View Cart</button>
    </body>
</html>