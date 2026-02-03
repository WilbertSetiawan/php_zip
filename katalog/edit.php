<?php
require_once '../../config/database.php';
session_start();

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $id_kategori = !empty($_POST['id_kategori']) ? intval($_POST['id_kategori']) : NULL;
    $harga_jual = floatval($_POST['harga_jual']);
    $diskon = floatval($_POST['diskon'] ?? 0);
    $is_aktif = intval($_POST['is_aktif'] ?? 1);
    $keterangan = mysqli_real_escape_string($mysqli, $_POST['keterangan'] ?? '');
    
    $query = "UPDATE tbl_katalog SET 
                id_kategori = " . ($id_kategori ? "'$id_kategori'" : "NULL") . ",
                harga_jual = '$harga_jual',
                diskon = '$diskon',
                is_aktif = '$is_aktif',
                keterangan = '$keterangan'
              WHERE id = '$id'";
    
    if (mysqli_query($mysqli, $query)) {
        $_SESSION['success'] = "✅ Katalog berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "❌ Gagal: " . mysqli_error($mysqli);
    }
}

header("Location: main.php?module=katalog");
exit();
?>