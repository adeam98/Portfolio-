<?php
require_once '../../../controllers/auth/authuser.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = Authuser::register($name, $email, $password);

    if ($result === true) {
        header('Location: ../../../views/auth/login.php?success=1');
        exit;
    } else {
        header('Location: ../../../views/auth/register.php?error=' . urlencode($result));
        exit;
    }
}
