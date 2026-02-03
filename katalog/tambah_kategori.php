<?php
// Path yang benar: naik 2 level ke config
require_once '../../config/database.php';
session_start();

if (isset($_POST['nama_kategori'])) {
    $nama = mysqli_real_escape_string($mysqli, $_POST['nama_kategori']);
    $deskripsi = mysqli_real_escape_string($mysqli, $_POST['deskripsi'] ?? '');
    
    $query = "INSERT INTO tbl_kategori (nama_kategori, deskripsi) VALUES ('$nama', '$deskripsi')";
    
    if (mysqli_query($mysqli, $query)) {
        $_SESSION['success'] = "✅ Kategori berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = "❌ Gagal: " . mysqli_error($mysqli);
    }
}

header("Location: main.php?module=katalog");
exit();
?>