<?php
require_once 'config/database.php';
session_start();

if (!isset($_POST['login'])) {
    header("Location: index.php");
    exit;
}

$email    = mysqli_real_escape_string($mysqli, $_POST['email']);
$password = $_POST['password'];

$query = mysqli_query(
    $mysqli,
    "SELECT * FROM tbl_users WHERE email='$email' AND is_aktif=1"
);

if (mysqli_num_rows($query) === 1) {
    $data = mysqli_fetch_assoc($query);

    if (password_verify($password, $data['password'])) {
        $_SESSION['id_user']   = $data['id'];
        $_SESSION['username']  = $data['username'];
        $_SESSION['email']     = $data['email'];
        $_SESSION['hak_akses'] = $data['hak_akses'];

        header("Location: main.php?modules=beranda");
        exit;
    }
}

header("Location: index.php?alert=1");
exit;