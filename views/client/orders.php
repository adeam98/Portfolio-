<?php

require '../../config/db.php';
require_once '../../helpers/auth.php';
requireLogin();
require_once '../navbar.php';

$user = $_SESSION['user'];
$user_id = $user['id'];

$stmt = $pdo->prepare("
    SELECT id, created_at, status, total_price, payment_method
    FROM orders 
    WHERE user_id = :user_id
    ORDER BY created_at DESC
");
$stmt->execute(['user_id' => $user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($orders as &$order) {
    $stmtItems = $pdo->prepare("
        SELECT ho.quantity, ho.price, p.name
        FROM historique_orders ho
        JOIN products p ON ho.product_id = p.id
        WHERE ho.order_id = :order_id
    ");
    $stmtItems->execute(['order_id' => $order['id']]);
    $order['items'] = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Commandes </title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      color: #fff;
      margin: 0;
      padding: 2rem;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,255,255,0.1);
      backdrop-filter: blur(15px);
      padding: 2rem;
    }
    h1 {
      font-family: 'Orbitron', sans-serif;
      text-align: center;
      color: #00ffff;
      margin-bottom: 2rem;
      text-shadow: 0 0 10px #00ffff88;
    }
    .order {
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 2rem;
      background: rgba(255,255,255,0.03);
    }
    .order h3 {
      font-family: 'Orbitron', sans-serif;
      color: #ffd200;
      margin-top: 0;
    }
    .order p {
      margin: 0.3rem 0;
    }
    ul {
      padding-left: 1.5rem;
    }
    li {
      margin-bottom: 0.5rem;
    }
    .no-orders {
      text-align: center;
      font-size: 1.2rem;
      color: #ccc;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Mes Commandes</h1>

    <?php if (empty($orders)): ?>
      <p class="no-orders">Aucune commande passée pour le moment.</p>
    <?php else: ?>
      <?php foreach ($orders as $order): ?>
        <div class="order">
          <h3>Commande #<?= $order['id'] ?> — <?= $order['created_at'] ?></h3>
          <p><strong>Statut :</strong> <?= htmlspecialchars($order['status']) ?></p>
          <p><strong>Total :</strong> <?= number_format($order['total_price'], 2) ?> €</p>
          <p><strong>Paiement :</strong> <?= htmlspecialchars($order['payment_method']) ?></p>

          <?php if (!empty($order['items'])): ?>
            <p><strong>Produits :</strong></p>
            <ul>
              <?php foreach ($order['items'] as $item): ?>
                <li><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?> — <?= number_format($item['price'], 2) ?> €</li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>
