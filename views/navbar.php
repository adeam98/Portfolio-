<?php 
if (!isset($_SESSION)) session_start();
require_once '../../helpers/auth.php'; 
?>

<div class="greeting">
  Bonjour, <?= isLoggedIn() ? htmlspecialchars($_SESSION['user']['name']) : 'Invité' ?>
</div>

<nav class="navbar">
  <ul>
    <li><a href="./products.php">Produits</a></li>
    <li><a href="./panier.php">Panier</a></li>
    <li><a href="./orders.php">Commandes</a></li>

    <?php if (isLoggedIn()): ?>
      <li>
        <form action="../auth/logout.php" method="POST" style="display:inline;">
          <button type="submit" class="logout-btn">Déconnexion</button>
        </form>
      </li>
    <?php else: ?>
      <li>
        <a href="../auth/login.php" class="login-link">Connexion</a>
      </li>
    <?php endif; ?>
  </ul>
</nav>

<style>
.greeting {
  position: fixed;
  top: 1rem;
  left: 1rem;
  color: #00ffff;
  font-weight: 700;
  font-size: 1.3rem;
  text-shadow: 0 0 8px #00ffffaa;
  user-select: none;
  pointer-events: none;
  z-index: 1000;
  font-family: 'Orbitron', sans-serif;
}

.navbar {
  background: rgba(0, 255, 255, 0.08);
  padding: 1rem 3rem;
  border-bottom: 1px solid rgba(255,255,255,0.1);
  backdrop-filter: blur(10px);
  margin-bottom: 2rem;
  border-radius: 0 0 12px 12px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: 'Orbitron', sans-serif;
}

.navbar ul {
  display: flex;
  gap: 2rem;
  list-style: none;
  margin: 0;
  padding: 0;
  align-items: center;
}

.navbar a {
  text-decoration: none;
  color: #00ffff;
  font-weight: bold;
  transition: color 0.3s;
}

.navbar a:hover {
  color: #ffd200;
}

.logout-btn {
  background: transparent;
  border: 1px solid #00ffff;
  color: #00ffff;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s;
}

.logout-btn:hover {
  background: #00ffff;
  color: #000;
}

.login-link {
  padding: 0.5rem 1rem;
  border: 1px solid #00ffff;
  border-radius: 8px;
  color: #00ffff;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s;
}

.login-link:hover {
  background: #00ffff;
  color: #000;
}
</style>
