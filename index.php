<?php
session_start();

// Cek apakah pengguna sudah login
$loggedIn = isset($_SESSION['user_id']);
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 80%;
            max-width: 1200px;
            margin: 20px auto;
            text-align: center;
        }
        .button-container a {
            text-decoration: none;
            padding: 10px 15px;
            margin: 0 10px;
            border-radius: 4px;
            color: white;
        }
        .login-btn { background-color: #007bff; }
        .register-btn { background-color: #28a745; }
        .logout-btn { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Movie App</h1>

        <?php if ($loggedIn): ?>
            <p>Halo, Anda sudah login!</p>
            <div class="button-container">
                <a href="home.php" class="login-btn">Lihat Daftar Film</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        <?php else: ?>
            <p>Silakan login atau daftar untuk mengakses lebih banyak fitur.</p>
            <div class="button-container">
                <a href="login.php" class="login-btn">Login</a>
                <a href="register.php" class="register-btn">Register</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
