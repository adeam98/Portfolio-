<?php
require_once '../../../controllers/client/commande.php';
session_start();

$user_id = $_SESSION['user']['id'] ?? null;

if (!$user_id) {
    die("Vous devez être connecté pour passer une commande.");
}

$payment_method = $_POST['payment_method'] ?? 'delivery';

try {
    Commande::creerCommande($user_id, $payment_method);
    header('Location: ../../../views/client/orders.php');
    exit;
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
