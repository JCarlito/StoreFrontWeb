<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
  $_SESSION['logged_in'] = false;
}

if ($_SESSION['logged_in'] === false) {
  header('Location: sign_in.html');
}

include 'db_connection.php';

// Connect to the database
$conn = OpenCon();

// Fetch cart items for the current user
$stmt = $conn->prepare("SELECT c.quantity, c.product_id, i.brand, i.model, i.price 
                        FROM cart c 
                        JOIN inventory i ON c.product_id = i.product_id 
                        WHERE c.user_id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);

$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<htm1> 
    <head>
        <title> Shopping Cart </title>
    </head>
    <body>
        <?php
            if ($result->num_rows == 0) {
                echo "<h4>Cart is empty!</h4>";
            }
        ?>

        <table>
            <?php
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<form action='php_scripts/update_cart.php' method='post'>";
                echo "<td>" . $row["brand"] . "</td>";
                echo "<td>" . $row["model"] . "</td>";
                echo "<td>$" . $row["price"] . "</td>";
                echo "<td>";
                echo "<select name='quantity'>";
                for ($i = 0; $i <= 10; $i++) {
                    if ($i == $row["quantity"]) {
                        echo "<option value=\"$i\" selected>$i</option>";
                    } else {
                        echo "<option value=\"$i\">$i</option>";
                    }
                }
                echo "</select>";
                echo "<input type='hidden' name='product_id' value='" . 
                        $row["product_id"] . "'>";
                echo "<input type='submit' name='update_cart' value='Update'>";
                echo "</td>";
                echo "</form>";
                echo "</tr>";
              }
            ?>
        </table>
        <button onclick="location.href='php_scripts/clear_cart.php'">Clear Cart</button>
        <button onclick="location.href='php_scripts/checkout_cart.php'">Checkout</button>
        <button onclick="location.href='store_front.php'">Return to Store Front</button>
    </body>
</html>

