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
$stmt = $conn->prepare("SELECT c.quantity, c.product_id, i.brand, i.model, i.price, i.image 
                        FROM cart c 
                        JOIN inventory i ON c.product_id = i.product_id 
                        WHERE c.user_id = ?");
$stmt->bind_param('i', $_SESSION['user_id']);

$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
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
            width: 250px;
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

        .item .quantity-container {
            display: flex;
            justify-content: space-between;
        }

        .item select {
            padding: 5px;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .clear-cart-btn {
            background-color: #f44336;
        }

        .checkout-btn {
            background-color: #FF9800;
        }

        .return-btn {
            background-color: #2196F3;
        }
    </style>
</head>
<body>
    <h1>Shopping Cart</h1>
    <div class="container">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<div class='item'>";
            echo "<img src='images/" . $row['image'] . "' alt='Item image'>";
            echo "<h3>" . $row['brand'] . "</h3>";
            echo "<p>Model: " . $row['model'] . "</p>";
            echo "<p>Price: $" . $row['price'] . "</p>";
            echo "<div class='quantity-container'>";
            echo "<form action='php_scripts/update_cart.php' method='post'>";
            echo "<select name='quantity'>";
            for ($i = 0; $i <= 50; $i++) {
                if ($i == $row['quantity']) {
                    echo "<option value='$i' selected>$i</option>";
                } else {
                    echo "<option value='$i'>$i</option>";
                }
            }
            echo "</select>";
            echo "<input type='hidden' name='product_id' value='" . $row['product_id'] . "'>";
            echo "<input type='submit' name='update_cart' value='Update'>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    <div class="button-container">
        <button class="clear-cart-btn" onclick="location.href='php_scripts/clear_cart.php'">Clear Cart</button>
        <button class="checkout-btn" onclick="location.href='php_scripts/checkout_cart.php'">Checkout</button>
        <button class="return-btn" onclick="location.href='store_front.php'">Return to Store Front</button>
    </div>
</body>
</html>
