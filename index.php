<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'home':
        include 'home.php';
        break;
    case 'add_movie':
        include 'add_movie.php';
        break;
    case 'detail':
        include 'detail.php';
        break;
    case 'update':
        include 'update.php';
        break;
    default:
        echo "Halaman tidak ditemukan!";
        break;
}
?>
