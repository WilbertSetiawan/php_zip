<?php
require_once 'config/database.php';
require_once 'config/fungsi_tanggal.php';
require_once 'config/fungsi_rupiah.php';

// Debug: Lihat apa yang dikirim
echo "<!-- DEBUG: module = " . ($_GET['module'] ?? 'NULL') . " -->\n";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
    exit;
}

$module = isset($_GET['module']) ? $_GET['module'] : 'beranda';

echo "<!-- DEBUG: Module yang dipilih = $module -->\n";

// TEST DULU dengan switch yang sederhana
switch ($module) {
    // Tambahkan di switch statement:
    case 'katalog':
        include 'modules/katalog/view.php';
        break;

    case 'beranda':
        echo "<!-- DEBUG: Loading beranda -->\n";
        include 'modules/beranda/view.php';
        break;
        
    case 'input_barang': 
        echo "<!-- DEBUG: Loading input_barang -->\n";
        include 'modules/barang/input_barang.php';
        break;
        
    case 'kategori':
        echo "<!-- DEBUG: Loading kategori -->\n";
        include 'modules/kategori/view.php';
        break;
        
    case 'satuan':
        echo "<!-- DEBUG: Loading satuan -->\n";
        include 'modules/satuan/view.php';
        break;
        
    case 'barang':
        echo "<!-- DEBUG: Loading barang -->\n";
        include 'modules/barang/view.php';
        break;
        
    case 'penjualan':
        echo "<!-- DEBUG: Loading penjualan -->\n";
        include 'modules/penjualan/view.php';
        break;
        
    default:
        echo "<!-- DEBUG: Default ke beranda -->\n";
        include 'modules/beranda/view.php';
        break;
}
?>