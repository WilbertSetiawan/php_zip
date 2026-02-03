<?php
require_once '../../config/database.php';
session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $query = "DELETE FROM tbl_katalog WHERE id = '$id'";
    
    if (mysqli_query($mysqli, $query)) {
        $_SESSION['success'] = "✅ Item katalog berhasil dihapus!";
    } else {
        $_SESSION['error'] = "❌ Gagal: " . mysqli_error($mysqli);
    }
}

header("Location: main.php?module=katalog");
exit();
?>