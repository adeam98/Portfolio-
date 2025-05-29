<?php
require_once __DIR__ . '/../../config/db.php';

class Authuser {
    public static function register($name, $email, $password) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return "Cet email est déjà utilisé.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if($stmt->execute([$name, $email, $hashedPassword]))
            return true;
        else
            return "Erreur lors de l'enregistrement. Veuillez réessayer.";
    }
public static function registeradmin($name, $email, $password) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return "Cet email est déjà utilisé.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')");
       if( $stmt->execute([$name, $email, $hashedPassword]))
            return true;
        else
            return "Erreur lors de l'enregistrement. Veuillez réessayer.";
    }
    public static function login($email, $password) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user'] = $user;
            return true;
        }

        return "Email ou mot de passe incorrect.";
    }
}
?>