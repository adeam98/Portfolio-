<?php
require_once '../../../controllers/auth/authuser.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = Authuser::login($email, $password);

    if ($result === true) {

        if ($_SESSION['user']['role'] === 'admin') {
            header('Location: ../../../views/auth/login.php?error=' . urlencode($result));
        } else {
            header('Location: ../../../views/client/products.php');
        }
        exit;
    } else {
        header('Location: ../../../views/auth/login.php?error=' . urlencode($result));
        exit;
    }
}
