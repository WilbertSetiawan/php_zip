<?php
require_once 'config/database.php';
require_once 'config/fungsi_rupiah.php';

$success = $error = '';

// PROSES SIMPAN - SIMPLE VERSION
if (isset($_POST['simpan'])) {
    // Ambil data dari form
    $nama = mysqli_real_escape_string($mysqli, $_POST['nama_barang']);
    $dus = intval($_POST['jumlah_dus'] ?? 0);
    $bungkus = intval($_POST['jumlah_bungkus'] ?? 0);
    $harga = floatval($_POST['harga']);
    $keterangan = mysqli_real_escape_string($mysqli, $_POST['keterangan'] ?? '');
    
    // Validasi sederhana
    if (empty($nama) || $harga <= 0) {
        $error = "Nama barang dan harga harus diisi!";
    } else {
        $total_stok = $dus + $bungkus;
        $kode = 'BRG-' . date('YmdHis') . rand(100, 999);
        $tanggal = date('Y-m-d H:i:s');
        $user_id = $_SESSION['id_user'] ?? 1; // Default ke 1 jika tidak ada
        
        // Query INSERT
        $query = "INSERT INTO tbl_barang (
                    kode_barang, 
                    nama_barang, 
                    jumlah_dus, 
                    jumlah_bungkus, 
                    total_stok, 
                    harga, 
                    keterangan, 
                    tanggal_masuk, 
                    id_user
                  ) VALUES (
                    '$kode',
                    '$nama',
                    $dus,
                    $bungkus,
                    $total_stok,
                    $harga,
                    '$keterangan',
                    '$tanggal',
                    $user_id
                  )";
        
        // Eksekusi
        if (mysqli_query($mysqli, $query)) {
            $success = "Barang <strong>$nama</strong> berhasil ditambahkan!";
            
            // Auto-refresh halaman setelah 1 detik
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '?module=input_barang';
                    }, 1000);
                  </script>";
        } else {
            $error = "Error: " . mysqli_error($mysqli);
        }
    }
}

// Ambil data barang terbaru
$data_barang = mysqli_query($mysqli, 
    "SELECT * FROM tbl_barang ORDER BY id DESC LIMIT 5");
?>

<div class="container-fluid px-4">
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-cube me-2 text-primary"></i> Input Barang Baru
        </h1>
        <a href="?module=beranda" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- ALERT MESSAGES -->
    <?php if($success): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <?php if($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- FORM INPUT -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Barang Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" id="barangForm">
                        <div class="mb-3">
                            <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_barang" class="form-control" 
                                   placeholder="Contoh: Mika,dll" required autofocus>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Jumlah (Dus)</label>
                                <input type="number" name="jumlah_dus" class="form-control" value="0" min="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jumlah (Bungkus)</label>
                                <input type="number" name="jumlah_bungkus" class="form-control" value="0" min="0">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga" class="form-control" 
                                       placeholder="15000" required min="100" step="100">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" 
                                      placeholder="Catatan tambahan..."></textarea>
                        </div>
                        
                        <button type="submit" name="simpan" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-save me-1"></i> SIMPAN BARANG
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- DATA TERBARU -->
        <div class="col-md-6">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-history me-2"></i> Barang Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <?php if(mysqli_num_rows($data_barang) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th class="text-center">Total Stok</th>
                                    <th>Harga Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($data_barang)): ?>
                                <tr>
                                    <td class="fw-semibold">
                                        <?php echo $row['nama_barang']; ?>
                                        <?php if(!empty($row['keterangan'])): ?>
                                        <br><small class="text-muted"><?php echo $row['keterangan']; ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><?php echo $row['total_stok']; ?></span>
                                    </td>
                                    <td class="text-primary fw-bold">
                                        Rp <?php echo format_rupiah($row['harga']); ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-cube fa-3x mb-3 opacity-25"></i>
                        <p class="mb-1">Belum ada data barang</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Simple form validation
document.getElementById('barangForm').addEventListener('submit', function(e) {
    const harga = document.querySelector('input[name="harga"]').value;
    if (harga < 100) {
        alert('Harga minimal Rp 100');
        e.preventDefault();
        return false;
    }
    return true;
});
</script>