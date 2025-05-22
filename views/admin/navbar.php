<?php
 
?>

<nav style="background-color: #007bff; padding: 1rem; display: flex; justify-content: space-between; align-items: center; color: white; font-family: 'Inter', sans-serif;">
    <div style="font-weight: bold; font-size: 1.2rem;">
        Admin Dashboard
    </div>
    <div style="display: flex; gap: 1rem; align-items: center;">
        <a href="./products.php" style="color: white; text-decoration: none;">Produits</a>
        <a href="./clients.php" style="color: white; text-decoration: none;">Clients</a>
        <form action="./auth/logout.php" method="POST" style="margin: 0;">
            <button type="submit" style="padding: 0.5rem 1rem; background: #dc3545; border: none; color: white; border-radius: 5px; cursor: pointer;">
                Se déconnecter
            </button>
        </form>
    </div>
</nav>
