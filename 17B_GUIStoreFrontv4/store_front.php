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
<html>
    <head>
        <title>Shoe Odyssey</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            h1 {
                text-align: center;
                margin-top: 20px;
                color: #333;
            }

            .container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .item {
                width: 33.33%;
                margin: 10px;
                padding: 15px;
                box-sizing: border-box;
                text-align: center;
                border: 1px solid #ddd;
                border-radius: 5px;
            }

            .item img {
                width: 150px;
            }

            .item h3 {
                margin-top: 10px;
                color: #333;
            }

            .item p {
                margin: 5px 0;
                color: #777;
                text-align: left;
            }

            .view-cart-btn {
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #4CAF50;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                font-size: 16px;
                cursor: pointer;
                border: none;
                border-radius: 5px;
            }

            .sign-out-btn {
                position: fixed;
                top: 20px;
                left: 20px;
                background-color: #4CAF50;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                font-size: 16px;
                cursor: pointer;
                border: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <h1>The Shoe Odyssey</h1>
        <div class="container">
            <?php
            include 'db_connection.php';

            $conn = OpenCon();
            $sql = "SELECT * FROM inventory WHERE status = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='item'>";
                    echo "<img src='images/" . $row['image'] . "' alt='Item image'>";
                    echo "<h3>" . $row['brand'] . "</h3>";
                    echo "<p>Model: " . $row['model'] . "</p>";
                    echo "<p>Price: $" . $row['price'] . "</p>";
                    echo "<p>Stock: " . $row['stock'] . "</p>";
                    echo "<form action='php_scripts/add_to_cart.php' method='post'>";
                    echo "<input type='hidden' name='product_id' value='" . $row['product_id'] . "'>";
                    echo "<input type='hidden' name='brand' value='" . $row['brand'] . "'>";
                    echo "<input type='hidden' name='model' value='" . $row['model'] . "'>";
                    echo "<input type='hidden' name='price' value='" . $row['price'] . "'>";
                    echo "<select id='quantity' name='quantity'>";
                    $max = 10;
                    for ($i = 1; $i <= $max; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    echo "</select>";
                    echo "<input type='submit' name='add_to_cart' value='Add to Cart'>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No inventory available.</p>";
            }

            CloseCon($conn);
            ?>
        </div>
        <button class="view-cart-btn" onclick="location.href = 'shopping_cart.php'">View Cart</button>
        <form id="sign-out-form" action="php_scripts/sign_out.php" method="post">
            <button type="submit" class="sign-out-btn">Sign Out</button>
        </form>
    </body>
</html>
