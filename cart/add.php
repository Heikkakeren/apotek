<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['id'];

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = ['quantity' => 1];
    } else {
        $_SESSION['cart'][$productId]['quantity']++;
    }

    echo json_encode(['cartCount' => count($_SESSION['cart'])]);
}
?>