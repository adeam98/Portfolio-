<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inscription — Adeam Shop</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      color: #fff;
    }

    .login-container {
      width: 380px;
      padding: 2rem;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,255,255,0.15);
      backdrop-filter: blur(15px);
      animation: float 6s ease-in-out infinite;
      position: relative;
      z-index: 1;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .login-header {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .login-header h1 {
      font-family: 'Orbitron', sans-serif;
      font-size: 2rem;
      color: #00ffff;
      text-shadow: 0 0 10px #00ffff88;
    }

    .login-header p {
      font-size: 0.9rem;
      opacity: 0.8;
    }

    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-group input {
      width: 100%;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.15);
      color: #fff;
      outline: none;
    }

    .form-group input:focus {
      background: rgba(255,255,255,0.2);
      border-color: #00ffff;
    }

    .form-group label {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      font-size: 0.9rem;
      color: #aaa;
      pointer-events: none;
      transition: all 0.3s ease;
    }

    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
      top: -0.6rem;
      font-size: 0.75rem;
      color: #ffd200;
    }

    .btn {
      width: 100%;
      padding: 0.75rem 1rem;
      background: linear-gradient(45deg, #f7971e, #ffd200);
      border: none;
      border-radius: 8px;
      color: #222;
      font-weight: 600;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform 0.3s;
      font-family: 'Orbitron', sans-serif;
    }

    .btn:hover {
      transform: scale(1.05);
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: rgba(255,255,255,0.3);
      transform: skewX(-20deg);
      transition: left 0.5s;
    }

    .btn:hover::before {
      left: 200%;
    }

    .footer {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.85rem;
      color: #ccc;
    }

    .footer a {
      color: #ffd200;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    .glow-circle {
      position: absolute;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(0,255,255,0.15), transparent 60%);
      z-index: 0;
      animation: spin 25s linear infinite;
    }

    .glow-circle.one {
      width: 250px;
      height: 250px;
      top: -80px;
      left: -80px;
    }

    .glow-circle.two {
      width: 300px;
      height: 300px;
      bottom: -100px;
      right: -100px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <div class="glow-circle one"></div>
  <div class="glow-circle two"></div>

  <div class="login-container">
    <div class="login-header">
      <h1>Inscription</h1>
      <p>Créez votre compte Adeam, iLyas Shop</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
      <div style="margin-bottom:1rem;padding:0.75rem;background:rgba(255,0,0,0.2);color:#fff;border-radius:6px;">
        <?= htmlspecialchars($_GET['error']) ?>
      </div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
      <div style="margin-bottom:1rem;padding:0.75rem;background:rgba(0,255,0,0.2);color:#fff;border-radius:6px;">
        Inscription réussie ! Vous pouvez vous connecter.
      </div>
    <?php endif; ?>

    <form method="POST" action="../../routes/client/auth/register.php">
      <div class="form-group">
        <input type="text" name="name" id="name" placeholder=" " required autocomplete="off" />
        <label for="name">Nom complet</label>
      </div>
      <div class="form-group">
        <input type="email" name="email" id="email" placeholder=" " required autocomplete="off" />
        <label for="email">Email</label>
      </div>
      <div class="form-group">
        <input type="password" name="password" id="password" placeholder=" " required />
        <label for="password">Mot de passe</label>
      </div>
      <button type="submit" class="btn">S'inscrire</button>
    </form>

    <div class="footer">
      Déjà un compte ? <a href="./login.php">Se connecter</a>
    </div>
  </div>
</body>
</html>
