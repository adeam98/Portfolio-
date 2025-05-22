<?php
require_once __DIR__ . '/../../config/db.php';

class Panier {

    public static function ajouterAuPanier($user_id, $product_id, $quantite) {
        global $pdo;

        $check = $pdo->prepare("SELECT id, quantity FROM panier WHERE user_id = ? AND product_id = ?");
        $check->execute([$user_id, $product_id]);
        $item = $check->fetch();

        if ($item) {

            $newQuantity = $item['quantity'] + $quantite;
            $update = $pdo->prepare("UPDATE panier SET quantity = ? WHERE id = ?");
            return $update->execute([$newQuantity, $item['id']]);
        } else {

            $insert = $pdo->prepare("INSERT INTO panier (user_id, product_id, quantity) VALUES (?, ?, ?)");
            return $insert->execute([$user_id, $product_id, $quantite]);
        }
    }

    public static function getPanierByUserId($user_id) {
        global $pdo;

        $sql = "
            SELECT ci.id AS cart_item_id, ci.quantity, 
                   p.id AS product_id, p.name, p.price, p.image
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.user_id = ?
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function supprimerItem($cart_item_id, $user_id) {
        global $pdo;

        $stmt = $pdo->prepare("DELETE FROM panier WHERE id = ? AND user_id = ?");
        return $stmt->execute([$cart_item_id, $user_id]);
    }
    public static function modifierQuantite($cart_item_id, $quantite, $user_id) {
        global $pdo;

        $stmt = $pdo->prepare("UPDATE panier SET quantity = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$quantite, $cart_item_id, $user_id]);
    }
}
