<?php
require_once '../../helpers/auth.php';
requireAdmin();
require_once '../../config/db.php';
require './navbar.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $category = $_POST['category'] ?? '';
    $image = $_POST['image'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category, image, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$name, $description, $price, $category, $image]);
}

if (isset($_POST['delete_product'])) {
    $productId = $_POST['product_id'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$productId]);
}

if (isset($_POST['update_product'])) {
    $id = $_POST['product_id'];
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $category = $_POST['category'] ?? '';
    $image = $_POST['image'] ?? '';

    $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, category=?, image=? WHERE id=?");
    $stmt->execute([$name, $description, $price, $category, $image, $id]);
}

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Produits</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 2rem;
        }
        h1 {
            text-align: center;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .card {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 6px;
        }
        form {
            margin-top: 1rem;
        }
        input, textarea {
            width: 100%;
            margin: 0.4rem 0;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 0.5rem 1rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
        .popup {
            background: #fff;
            border: 1px solid #ddd;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .add-box {
            max-width: 400px;
            margin: 2rem auto;
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<h1>Gestion des Produits</h1>
<div class="add-box">
    <h3>Ajouter un nouveau produit</h3>
    <form method="POST">
        <input type="text" name="name" placeholder="Nom" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" step="0.01" name="price" placeholder="Prix" required>
        <input type="text" name="category" placeholder="Catégorie" required>
        <input type="text" name="image" placeholder="URL de l'image" required>
        <button type="submit" name="add_product">Ajouter</button>
    </form>
</div>

<div class="grid">
    <?php foreach ($products as $product): ?>
        <div class="card">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Image">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><?= htmlspecialchars($product['description']) ?></p>
            <p><strong><?= number_format($product['price'], 2) ?> €</strong></p>

            <div class="actions">
                <form method="POST" style="width: 48%;">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="text" name="name" placeholder="Nom" value="<?= $product['name'] ?>">
                    <textarea name="description" placeholder="Description"><?= $product['description'] ?></textarea>
                    <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>">
                    <input type="text" name="category" value="<?= $product['category'] ?>">
                    <input type="text" name="image" value="<?= $product['image'] ?>">
                    <button type="submit" name="update_product">Modifier</button>
                </form>

                <form method="POST" style="width: 48%;">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" name="delete_product" style="background:red;">Supprimer</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
