<?php
session_start();
include 'db_connection.php';

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
    <title>Admin - Edit Inventory</title>
    <style>
        /* CSS styles for the page layout */
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
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        form input[type="text"],
        form input[type="file"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 5px;
        }

        form label {
            margin-right: 10px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Additional Styling */
        th {
            color: white;
            background-color: #4CAF50;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* CSS styles for the home button */
        .home-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .home-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <!-- Home Button -->
    <a class="home-button" href="admin.php">Home</a>

    <h1>Edit Inventory</h1>
    <table>
        <tr>
            <th>Brand</th> 
            <th>Name</th>
            <th>Price $</th>
            <th>Stock</th>
            <th>Image</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        $conn = OpenCon();
        $sql = "SELECT * FROM inventory";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>";
                echo "<form action='php_scripts/edit_item.php' method='post' enctype='multipart/form-data'>";
                echo "<input type='hidden' name='product_id' value='" . $row["product_id"] . "'>";
                echo "<input type='text' name='brand' value='" . $row["brand"] . "' required>";
                echo "</td>";
                echo "<td>";
                echo "<input type='text' name='model' value='" . $row["model"] . "' required>";
                echo "</td>";
                echo "<td>";
                echo "<input type='text' name='price' value='" . $row["price"] . "' required>";
                echo "</td>";
                echo "<td>";
                echo "<input type='text' name='stock' value='" . $row['stock'] . "' required>";
                echo "</td>";
                echo "<td>";
                echo "<input type='file' name='image'>";
                echo "</td>";
                echo "<td>";
                echo "<label><input type='radio' name='status' value='1' " . ($row['status'] == 1 ? 'checked' : '') . ">Activate</label>";
                echo "<label><input type='radio' name='status' value='0' " . ($row['status'] == 0 ? 'checked' : '') . ">Deactivate</label>";
                echo "</td>";
                echo "<td>";
                echo "<input type='submit' value='Edit Item' name='edit_item'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>NO INVENTORY!</td></tr>";
        }
        ?>
    </table>
</body>
</html>
