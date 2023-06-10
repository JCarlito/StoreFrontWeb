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
    <title>Admin - View Purchase History</title>
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

        form {
            display: inline-block;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        input[type="hidden"] {
            display: none;
        }
    </style>
</head>
<body>
    <h1>View User Purchase History</h1>
    <table>
        <tr>
            <th>Username</th> 
            <th>Actions</th>
        </tr>
        <?php
        $conn = OpenCon();
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>";
                echo "<form action='php_scripts/view_user_history.php' method='post'>";
                echo "<input type='hidden' name='username' value='" . $row["username"] . "'>";
                echo "<input type='hidden' name='user_id' value='" . $row["user_id"] . "'>";
                echo "<input type='submit' name='history' value='View Purchase History'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>NO USERS!</td></tr>";
        }
        ?>
    </table>
</body>
</html>
