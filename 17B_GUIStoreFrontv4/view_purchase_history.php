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
            /* CSS styles for the page layout */
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            h1 {
                margin-bottom: 20px;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                text-align: left;
                padding: 8px;
                border-bottom: 1px solid #ddd;
            }

            tr:hover {
                background-color: #f5f5f5;
            }

            th {
                background-color: #4CAF50;
                color: white;
            }

            p {
                margin-top: 10px;
                margin-bottom: 10px;
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
            }

            .home-button:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>
        <!-- Home Button -->
        <a class="home-button" href="admin.php">Home</a>

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
                echo "<tr><td colspan='2'>No users found!</td></tr>";
            }
            ?>
        </table>
    </body>
</html>
