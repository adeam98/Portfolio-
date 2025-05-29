<?php
require_once '../../../controllers/auth/authuser.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
 
    $result = Authuser::login($email, $password);

    if ($result === true) {
        header("Location: ../../../views/admin/products.php");
        exit;
    } else {
        header("Location: ../../../views/admin/auth/login.php?error=" . urlencode($result));
        exit;
    }

}
