<?php
require_once '../../../helpers/auth.php';
requireLogin();

require_once '../../../controllers/client/panier.php';

$user_id = $_SESSION['user']['id'];
$cart_item_id = $_POST['cart_item_id'];
$quantity = intval($_POST['quantity']);
 
if ($quantity > 0) {
    Panier::modifierQuantite($cart_item_id, $quantity, $user_id);
} else {
    Panier::supprimerItem($cart_item_id, $user_id);
}

header('Location: ../../../views/client/panier.php');
exit;
