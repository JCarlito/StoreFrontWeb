<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

?>
<!DOCTYPE html>
<htm1> 
    <head>
        <title> Shopping Cart </title>
    </head>
    <body>
        <?php
            if (empty($_SESSION['cart'])) {
                echo "<h4>Cart is empty!</h4>";
            }
        ?>

        <table>
            <?php
              foreach ($_SESSION['cart'] as &$item) {
                echo "<tr>";
                echo "<td>" . $item["brand"] . "</td>";
                echo "<td>" . $item["model"] . "</td>";
                echo "<td>$" . $item["price"] . "</td>";
                echo "<td>" . $item["count"] . "</td>";
                echo "</tr>";
              }
            ?>
        </table>
        <button onclick=location.href='php_scripts/clear_cart.php'>Clear Cart</button>
        <button onclick=location.href='new_store_front.php'>Return to Store Front</button>
    </body>
</html>
