<?php
require_once __DIR__ . '/../../config/db.php';

class Commande {

    public static function creerCommande($user_id, $payment_method) {
        global $pdo;

        try {
            $pdo->beginTransaction();

            $sql = "
                SELECT ci.product_id, ci.quantity, p.price
                FROM panier ci
                JOIN products p ON ci.product_id = p.id
                WHERE ci.user_id = ?
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id]);
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($cartItems)) {
                throw new Exception("Le panier est vide.");
            }

            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $insertOrder = $pdo->prepare("
                INSERT INTO orders (user_id, total_price, payment_method, status)
                VALUES (?, ?, ?, 'pending')
            ");
            $insertOrder->execute([$user_id, $total, $payment_method]);
            $order_id = $pdo->lastInsertId();

            $insertItem = $pdo->prepare("
                INSERT INTO historique_orders (order_id, product_id, quantity, price)
                VALUES (?, ?, ?, ?)
            ");

            foreach ($cartItems as $item) {
                $insertItem->execute([
                    $order_id,
                    $item['product_id'],
                    $item['quantity'],
                    $item['price']
                ]);
            }

            $deleteCart = $pdo->prepare("DELETE FROM panier WHERE user_id = ?");
            $deleteCart->execute([$user_id]);

            $pdo->commit();

            return $order_id;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function getHistoriqueCommandes($user_id) {
        global $pdo;

        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($orders as &$order) {
            $sqlItems = "
                SELECT oi.*, p.name 
                FROM historique_orders oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = ?
            ";
            $stmtItems = $pdo->prepare($sqlItems);
            $stmtItems->execute([$order['id']]);
            $order['items'] = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
        }

        return $orders;
    }
}
