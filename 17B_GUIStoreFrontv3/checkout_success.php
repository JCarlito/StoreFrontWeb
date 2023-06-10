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
<htm1> 
    <head>
        <title> Checkout Successful </title>
    </head>
    <body>
        <h1>Checkout Successful</h1>
        <button onclick="location.href='store_front.php'">Return to Store</button>
    </body>
</html>
