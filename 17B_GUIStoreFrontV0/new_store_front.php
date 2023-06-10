<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

if (!isset($_SESSION['logged_in'])) {
  $_SESSION['logged_in'] = false;
}

if ($_SESSION['logged_in'] === false) {
  header('Location: signin.php');
}

if(isset($_POST['AddToCart'])) {
  // if (item_in_cart) {
  //   count++
  // } else {
  //   add new item
  // }

  $a = [
    "id"    => $_POST['id'],
    'brand' => $_POST['brand'],
    'model' => $_POST['model'],
    'price' => $_POST['price'],
    'count' => 1,
  ];

  array_push($_SESSION['cart'], $a);
}
?>

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
                    echo "<form action='php_scripts' method='post'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<input type='hidden' name='brand' value='" . $row["brand"] . "'>";
                    echo "<input type='hidden' name='model' value='" . $row["model"] . "'>";
                    echo "<input type='hidden' name='price' value='" . $row["price"] . "'>";
                    echo "<input type='hidden' name='stock' value='1'>";
                    echo "<input type='submit' value='Add to Cart' name='add_to_cart'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "NO INVENTORY!";
            }
            ?>
        </table>
        <hr />
        <a href="shopping_cart.php">View Cart</a>
    </body>
</html>