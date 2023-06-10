<!DOCTYPE html>
<html>
<head>
    <title>Admin - Purchase History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: #555;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include '../db_connection.php';

    $conn = OpenCon();

    if (isset($_POST['history'])) {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];

        // Fetch order history for the user
        $stmt = $conn->prepare("SELECT orders.order_id, orders.date, orders.total, order_details.quantity, order_details.price, inventory.brand, inventory.model 
                                FROM orders 
                                INNER JOIN order_details ON orders.order_id = order_details.order_id 
                                INNER JOIN inventory ON order_details.product_id = inventory.product_id 
                                WHERE orders.user_id = ?");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h1>" . $username . "'s Purchase History</h1>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Brand</th>";
        echo "<th>Model</th>";
        echo "<th>Quantity</th>";
        echo "<th>Price</th>";
        echo "<th>Total</th>";
        echo "<th>Order ID</th>";
        echo "<th>Date</th>";
        echo "</tr>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $date = date('m/d/Y', strtotime($row["date"]));
                echo "<tr>";
                echo "<td>" . $row["brand"] . "</td>";
                echo "<td>" . $row["model"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>$" . $row["price"] . "</td>";
                echo "<td>$" . $row["total"] . "</td>";
                echo "<td>" . $row["order_id"] . "</td>";
                echo "<td>" . $date . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No purchase history found!</td></tr>";
        }

        echo "</table>";

        // Calculate total spent by the user
        $stmt2 = $conn->prepare("SELECT SUM(total) AS total_spent FROM orders WHERE user_id = ?");
        $stmt2->bind_param('i', $user_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $row2 = $result2->fetch_assoc();
        echo "<p>Total spent: $" . $row2['total_spent'] . "</p>";

        // Calculate the number of unique items bought by the user
        $stmt3 = $conn->prepare("SELECT COUNT(DISTINCT product_id) AS unique_items FROM order_details INNER JOIN orders ON orders.order_id = order_details.order_id WHERE orders.user_id = ?");
        $stmt3->bind_param('i', $user_id);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $row3 = $result3->fetch_assoc();
        echo "<p>Unique items bought: " . $row3['unique_items'] . "</p>";
    }

    // Close the database connection
    CloseCon($conn);
    ?>
</body>
</html>
