<!DOCTYPE html>
<html>
    <head>
        <title>Admin - Total Revenue</title>
    </head>
    <body>
        <?php
        session_start();
        include 'db_connection.php';

        $conn = OpenCon();

        // Fetch order history for the user
        $result = $conn->query("SELECT orders.order_id, orders.date, orders.total, order_details.quantity, order_details.price, inventory.brand, inventory.model 
                                FROM orders 
                                INNER JOIN order_details ON orders.order_id = order_details.order_id 
                                INNER JOIN inventory ON order_details.product_id = inventory.product_id");

        echo "<h1>Revenue</h1>";
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
        $result2 = $conn->query("SELECT SUM(total) AS total_spent FROM orders");
        $row2 = $result2->fetch_assoc();
        echo "<p>Total Revenue: $" . $row2['total_spent'] . "</p>";

        // Calculate the number of unique items bought by the user
        $result3 = $conn->query("SELECT COUNT(DISTINCT product_id) AS unique_items FROM order_details INNER JOIN orders ON orders.order_id = order_details.order_id");
        $row3 = $result3->fetch_assoc();
        echo "<p>Unique items sold: " . $row3['unique_items'] . "</p>";


        // Close the database connection
        CloseCon($conn);
        ?>
    </body>
</html>
