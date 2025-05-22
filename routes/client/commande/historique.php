<?php
require_once '../../../controllers/client/commande.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("Vous devez être connecté.");
}

$commandes = Commande::getHistoriqueCommandes($user_id);
include '../../../views/client/commande/historique.php';
