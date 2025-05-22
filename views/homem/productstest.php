<?php
require_once '../../helpers/auth.php';
requireLogin();
require_once '../navbar.php';

require_once '../../config/db.php';

// Fetch categories
$categoryStmt = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category ASC");
$categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);
$selectedCategory = $_GET['category'] ?? '';
$sql = "SELECT * FROM products";
$params = [];

if (!empty($selectedCategory)) {
    $sql .= " WHERE category = :category";
    $params[':category'] = $selectedCategory;
}

$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Produits — Adeam Shop</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      font-family: 'Inter', sans-serif;
      color: #fff;
      margin: 0;
      padding: 2rem;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .product-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      justify-content: center;
      max-width: 1200px;
    }

    .product-card {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 16px;
      padding: 1.5rem;
      width: 280px;
      box-shadow: 0 0 15px rgba(0,255,255,0.15);
      backdrop-filter: blur(10px);
      text-align: center;
      animation: float 6s ease-in-out infinite;
    }

    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 1rem;
    }

    .product-card h3 {
      font-family: 'Orbitron', sans-serif;
      color: #ffd200;
      margin-bottom: 0.5rem;
    }

    .product-card p {
      opacity: 0.8;
      font-size: 0.9rem;
      margin-bottom: 0.5rem;
    }

    .product-card .price {
      color: #00ffff;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    .btn {
      padding: 0.6rem 1rem;
      background: linear-gradient(45deg, #f7971e, #ffd200);
      border: none;
      border-radius: 8px;
      color: #222;
      font-family: 'Orbitron', sans-serif;
      cursor: pointer;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
  </style>
</head>
<body>
  <h1 style="font-family: 'Orbitron'; color: #00ffff;">Produits disponibles</h1>
<form method="GET" style="margin-bottom: 2rem; text-align: center;">
  <select name="category" class="btn">
    <option value="">Toutes les catégories</option>
    <?php foreach ($categories as $category): ?>
      <option value="<?= htmlspecialchars($category) ?>" <?= $selectedCategory == $category ? 'selected' : '' ?>>
        <?= htmlspecialchars($category) ?>
      </option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="btn">Filtrer</button>
</form>

  <div class="product-grid">
    <?php foreach ($products as $product): ?>
      <div class="product-card">
        <img src="./<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <h3><?= htmlspecialchars($product['name']) ?></h3>
        <p><?= htmlspecialchars($product['description']) ?></p>
        <div class="price"><?= number_format($product['price'], 2) ?> €</div>
        <form method="POST" action="../../routes/client/panier/add.php">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <button type="submit" class="btn">Ajouter au panier</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>
