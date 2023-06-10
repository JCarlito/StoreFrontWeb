<?php

session_start();
include '../cart.php';

if (isset($_SESSION['cart'])) {
    $cart = unserialize($_SESSION['cart']);
} else {
    $cart = new Cart();
}

if (isset($_POST['id'], $_POST['brand'], $_POST['model'], $_POST['price'], $_POST['stock'])) {
    $id = $_POST['id'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $cart->addItem($id, $brand, $model, $price, $stock);
    $_SESSION['cart'] = serialize($cart);
}

header('Location: ../store_front.php');
//var_dump($_SESSION);
exit();

