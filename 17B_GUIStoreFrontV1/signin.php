<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
  $_SESSION['logged_in'] = false;
}
?>

<!DOCTYPE html>
<htm1> 
    <head>
        <title> Shoe Odyssey - Sign In</title>
    </head>
    <body>
      <form action="php_scripts/login.php" method='post'>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br />
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <br />
        <input type="submit" value="Login" name="login">
      </form>

    </body>
</html>