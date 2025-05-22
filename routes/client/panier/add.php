<?php
require_once '../../../helpers/auth.php';
requireLogin();

require_once '../../../controllers/client/panier.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1;

    $quantity = max(1, intval($quantity));

    Panier::ajouterAuPanier($user_id, $product_id, $quantity);

    header('Location: ../../../views/client/panier.php');
    exit;
}
