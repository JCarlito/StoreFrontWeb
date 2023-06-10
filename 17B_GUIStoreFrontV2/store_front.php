<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}

if ($_SESSION['logged_in'] === false) {
    header('Location: sign_in.html');
}
?>

<!DOCTYPE html>
<htm1> 
    <head>
        <title> Shoe Odyssey </title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 15px;
                text-align: center;
            }
            th {
                background-color: #f2f2f2;
            }
            img {
                width: 100px;
            }
            button {
                background-color: #4CAF50;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
            }
        </style>
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
            include 'db_connection.php';

            $conn = OpenCon();
            $sql = "SELECT * FROM inventory WHERE status = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><img src=\"images/" . $row["image"] . "\" alt=\"Item image\"></td>";
                    echo "<td>" . $row["brand"] . "</td>";
                    echo "<td>" . $row["model"] . "</td>";
                    echo "<td>$" . $row["price"] . "</td>";
                    echo "<td>" . $row["stock"] . "</td>";
                    echo "<td>";
                    echo "<form action='php_scripts/add_to_cart.php' method='post'>";
                    echo "<input type='hidden' name='product_id' value='" . $row["product_id"] . "'>";
                    echo "<input type='hidden' name='brand' value='" . $row["brand"] . "'>";
                    echo "<input type='hidden' name='model' value='" . $row["model"] . "'>";
                    echo "<input type='hidden' name='price' value='" . $row["price"] . "'>";
                    echo "<select id='quantity' name='quantity'>";
                    $max = 10;
                    for ($i = 1; $i <= $max; $i++) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                    echo "</select>";
                    echo "<input type='submit' name='add_to_cart' value='Add to Cart'>";
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
        <button onclick="location.href = 'shopping_cart.php'">View Cart</button>
    </body>
</html>