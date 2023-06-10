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
        <title> Admin - Menu </title>
    </head>
    <body>
        <h1>Welcome to the Admin Page</h1>
    </body>
</html>
