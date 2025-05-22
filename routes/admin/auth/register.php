<?php
require_once '../../../controllers/auth/authuser.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $result = Authuser::registeradmin($name, $email, $password);

    if ($result === true) {
        header("Location: ../../../views/admin/auth/login.php");
        exit;
    } else {
        header("Location: register.php?error=" . urlencode($result));
        exit;
    }
}
