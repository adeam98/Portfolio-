<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Accueil</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet"/>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(120deg, #0f0c29, #302b63, #24243e);
      background-size: 600% 600%;
      animation: gradientShift 30s ease infinite;
      color: #ffffff;
      overflow-x: hidden;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    header {
      padding: 1.5rem 3rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(255, 255, 255, 0.03);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
    }

    header h1 {
      font-family: 'Orbitron', sans-serif;
      font-size: 2rem;
      color: #00ffe7;
      text-shadow: 0 0 10px #00ffe7;
    }

    nav a {
      margin-left: 2rem;
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      letter-spacing: 1px;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #00ffe7;
    }

    .hero {
      text-align: center;
      padding: 5rem 2rem 3rem;
    }

    .hero h2 {
      font-size: 3rem;
      font-family: 'Orbitron', sans-serif;
      margin-bottom: 1rem;
      color: #ffd700;
      text-shadow: 0 0 15px #ffd700;
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 700px;
      margin: 0 auto;
      opacity: 0.85;
    }

    .btn-glow {
      margin-top: 2rem;
      padding: 1rem 2rem;
      font-size: 1rem;
      font-weight: bold;
      border: none;
      background: #00ffe7;
      color: #000;
      border-radius: 10px;
      box-shadow: 0 0 20px #00ffe7;
      cursor: pointer;
      transition: all 0.3s;
    }

    .btn-glow:hover {
      transform: scale(1.05);
      box-shadow: 0 0 30px #00ffe7, 0 0 50px #00ffe7;
    }

    .categories {
      display: flex;
      justify-content: center;
      gap: 1rem;
      padding: 3rem 2rem 1rem;
      flex-wrap: wrap;
    }

    .category {
      background: rgba(255,255,255,0.05);
      padding: 1rem 1.5rem;
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 20px;
      backdrop-filter: blur(8px);
      font-weight: bold;
      text-transform: uppercase;
      color: #00ffe7;
      cursor: pointer;
      transition: background 0.3s;
    }

    .category:hover {
      background: rgba(0,255,231,0.1);
    }

    .products {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 2rem;
      padding: 2rem 3rem;
    }

    .product {
      background: rgba(255,255,255,0.05);
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,255,231,0.2);
      transition: transform 0.3s, box-shadow 0.3s;
      backdrop-filter: blur(10px);
    }

    .product:hover {
      transform: scale(1.03);
      box-shadow: 0 0 25px rgba(0,255,231,0.5);
    }

    .product img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .product-info {
      padding: 1rem;
    }

    .product-info h4 {
      font-size: 1.1rem;
      margin-bottom: 0.3rem;
      color: #ffd700;
    }

    .product-info p {
      font-size: 0.9rem;
      opacity: 0.8;
    }

    footer {
      text-align: center;
      padding: 2rem;
      font-size: 0.9rem;
      opacity: 0.6;
    }
     nav a.btn-outline {
    margin-left: 2rem;
    padding: 0.5rem 1rem;
    border: 2px solid #00ffe7;
    border-radius: 10px;
    color: #00ffe7;
    font-weight: 600;
    transition: background 0.3s, color 0.3s;
  }

  nav a.btn-outline:hover {
    background: #00ffe7;
    color: #000;
  }

  nav a.btn-glow {
    margin-left: 1rem;
    padding: 0.6rem 1.2rem;
    font-weight: 700;
    background: #00ffe7;
    color: #000;
    border-radius: 10px;
    box-shadow: 0 0 20px #00ffe7;
    transition: all 0.3s;
  }

  nav a.btn-glow:hover {
    transform: scale(1.1);
    box-shadow: 0 0 30px #00ffe7, 0 0 50px #00ffe7;
  }
  </style>
</head>
<body>
  <header>
    <h1>Adeam ,iLyas Shop</h1>
    <nav>
    
     <a href="./auth/login.php" class="btn-outline">Connexion</a>
    <a href="./auth/register.php" class="btn-glow">Inscription</a>
    </nav>
  </header>

  <section class="hero">
    <h2>Le Futur de votre Setup</h2>
    <p>Explorez les meilleurs équipements pour gamers et créateurs : PC portables, accessoires RGB, périphériques haute performance.</p>
    <button class="btn-glow"><a href="./auth/register.php">Découvrir maintenant</a></button>
  </section>

  <section class="categories">
    <div class="category">💻 Laptops</div>
    <div class="category">🎧 Casques</div>
    <div class="category">🖱️ Souris</div>
    <div class="category">⌨️ Claviers</div>
    <div class="category">🖥️ Écrans</div>
  </section>

  <footer>
    &copy; 2025 Adam,iLyas Shop — Designed with ⚡️ passion & coffee
  </footer>
</body>
</html>
