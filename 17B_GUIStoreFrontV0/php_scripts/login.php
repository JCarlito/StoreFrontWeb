<?php
  session_start();
  if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
  }


  if(isset($_POST['login']) && $_POST['password'] === 'asdf') {
    $_SESSION['logged_in'] = true;
    header('Location: ../new_store_front.php');
  } else {
    echo "<h1>Access Denied. Incorrect password</h1>";
  }
?>