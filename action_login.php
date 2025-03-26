<?php
session_start();

function verify_login($username, $password) {
    $file = 'users.txt'; 

    if (!file_exists($file)) {
        return false;
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        list($stored_user, $stored_pass) = explode('|', trim($line));
        if ($username === $stored_user && $password === $stored_pass) {
            return true;
        }
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (verify_login($username, $password)) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=Username atau password salah");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>