<?php
require_once '../../config/db.php';
require_once '../../helpers/auth.php';
requireAdmin();
require './navbar.php';

if (isset($_POST['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'client'");
    $stmt->execute([$_POST['delete_id']]);
    header("Location: clients.php");
    exit;
}

if (isset($_POST['update_id'])) {
    $params = [
        'name'     => $_POST['name'],
        'email'    => $_POST['email'],
        'password' => !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null,
        'id'       => $_POST['update_id']
    ];

    if ($params['password']) {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ? AND role = 'client'");
        $stmt->execute([$params['name'], $params['email'], $params['password'], $params['id']]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ? AND role = 'client'");
        $stmt->execute([$params['name'], $params['email'], $params['id']]);
    }

    header("Location: clients.php");
    exit;
}

$stmt = $pdo->query("SELECT id, name, email FROM users WHERE role = 'client'");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Clients</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 2rem;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .client-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .client-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .client-card h3 {
            margin: 0 0 0.5rem;
        }
        form {
            margin-top: 1rem;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-update {
            background-color: #007bff;
            color: white;
            margin-right: 0.5rem;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Gestion des Clients</h1>
    <div class="client-grid">
        <?php foreach ($clients as $client): ?>
            <div class="client-card">
                <form method="POST">
                    <input type="hidden" name="update_id" value="<?= $client['id'] ?>">
                    <label>Nom:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($client['name']) ?>" required>

                    <label>Email:</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($client['email']) ?>" required>

                    <label>Mot de passe (laisser vide si inchangé):</label>
                    <input type="password" name="password" placeholder="Nouveau mot de passe">

                    <button class="btn btn-update" type="submit">Mettre à jour</button>
                </form>
                <form method="POST" onsubmit="return confirm('Supprimer ce client ?');">
                    <input type="hidden" name="delete_id" value="<?= $client['id'] ?>">
                    <button class="btn btn-delete" type="submit">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
