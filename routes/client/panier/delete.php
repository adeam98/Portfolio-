<?php

require_once '../../../helpers/auth.php';
requireLogin();

require_once '../../../controllers/client/panier.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_item_id'])) {
    $user_id = $_SESSION['user']['id'];
    $cart_item_id = intval($_POST['cart_item_id']);

    Panier::supprimerItem($cart_item_id, $user_id);
}

header('Location: ../../../views/client/panier.php');
exit;
