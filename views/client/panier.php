<?php
require '../../config/db.php'; 
require_once '../../helpers/auth.php';
requireLogin();
require_once '../navbar.php';

$user = $_SESSION['user'];
$user_id = $user['id'];
$stmt = $pdo->prepare("
    SELECT c.id AS cart_id,
           p.id AS product_id,
           p.name,
           p.price,
           p.image,
           c.quantity
    FROM panier c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
    ORDER BY c.id ASC
");

$stmt->execute([$user_id]);
$cart_Items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($cart_Items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon Panier</title>
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
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
    }
    th, td {
      padding: 1rem;
      border-bottom: 1px solid rgba(255,255,255,0.1);
      text-align: center;
    }
    th {
      color: #ffd200;
      font-family: 'Orbitron', sans-serif;
    }
    img {
      width: 80px;
      border-radius: 8px;
    }
    .btn {
      background: linear-gradient(45deg, #f7971e, #ffd200);
      border: none;
      border-radius: 8px;
      padding: 0.5rem 1rem;
      color: #222;
      font-weight: bold;
      cursor: pointer;
      font-family: 'Orbitron', sans-serif;
      transition: transform 0.2s;
    }
    .btn:hover {
      transform: scale(1.05);
    }
    .total {
      font-size: 1.5rem;
      text-align: right;
      font-family: 'Orbitron', sans-serif;
      color: #00ffff;
    }
    .quantity-form {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
    }
    .quantity-input {
      width: 60px;
      padding: 0.3rem;
      border-radius: 4px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Mon Panier</h1>

    <?php if (count($cart_Items) === 0): ?>
        <p style="text-align: center; font-size: 1.2rem; color: #ccc;">Aucun produit dans le panier.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Produit</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Sous-total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cart_Items as $item): ?>
            <tr>
              <td><img src="../../uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"></td>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td><?= number_format($item['price'], 2) ?> €</td>
              <td>
                <form action="../../routes/client/panier/update.php" method="POST" class="quantity-form">
                  <input type="hidden" name="cart_item_id" value="<?= $item['cart_id'] ?>">
                  <input type="number" name="quantity" min="1" value="<?= $item['quantity'] ?>" class="quantity-input">
                  <button class="btn" type="submit">Mettre à jour</button>
                </form>
              </td>
              <td><?= number_format($item['price'] * $item['quantity'], 2) ?> €</td>
              <td>
                <form action="../../routes/client/panier/delete.php" method="POST">
                  <input type="hidden" name="cart_item_id" value="<?= $item['cart_id'] ?>">
                  <button class="btn" type="submit">Supprimer</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="total">
        Total : <?= number_format($total, 2) ?> €
      </div>
    <?php endif; ?>
  </div>
  <form action="../../routes/client/commande/add.php" method="POST" style="text-align: right; margin-top: 1rem;">
  <select name="payment_method" required style="margin-right: 1rem; padding: 0.5rem; font-family: 'Orbitron';">
    <option value="delivery">Paiement à la livraison</option>
    <option value="card">Carte bancaire</option>
  </select>
  <button class="btn" type="submit">Passer la commande</button>
</form>
</body>
</html>
