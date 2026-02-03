<?php
require_once '../../config/database.php';
session_start();

if (isset($_POST['id_barang'])) {
    $id_barang = intval($_POST['id_barang']);
    $id_kategori = !empty($_POST['id_kategori']) ? intval($_POST['id_kategori']) : NULL;
    $harga_jual = floatval($_POST['harga_jual']);
    $diskon = floatval($_POST['diskon'] ?? 0);
    $keterangan = mysqli_real_escape_string($mysqli, $_POST['keterangan'] ?? '');
    
    // Cek apakah barang sudah ada
    $check = mysqli_query($mysqli, "SELECT id FROM tbl_katalog WHERE id_barang = '$id_barang'");
    
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Barang ini sudah ada di katalog!";
    } else {
        $query = "INSERT INTO tbl_katalog (id_barang, id_kategori, harga_jual, diskon, keterangan) 
                  VALUES ('$id_barang', " . ($id_kategori ? "'$id_kategori'" : "NULL") . ", '$harga_jual', '$diskon', '$keterangan')";
        
        if (mysqli_query($mysqli, $query)) {
            $_SESSION['success'] = "Barang berhasil ditambahkan ke katalog!";
        } else {
            $_SESSION['error'] = "Gagal coba lagi: " . mysqli_error($mysqli);
        }
    }
}

header("Location: main.php?module=katalog");
exit();
?>