<?php
require_once 'config/database.php';
require_once 'config/fungsi_rupiah.php';
// Tampilkan pesan dari session
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>' . $_SESSION['success'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>' . $_SESSION['error'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>';
    unset($_SESSION['error']);
}
// SEARCH & FILTER
$search = $_GET['search'] ?? '';
$kategori_id = $_GET['kategori'] ?? '';

// Query dasar dengan join
$query = "SELECT 
            kt.id as katalog_id,
            b.nama_barang,
            b.kode_barang,
            b.total_stok as stok_awal,
            b.harga as harga_dasar,
            kt.harga_jual,
            kt.diskon,
            ktg.nama_kategori,
            kt.keterangan,
            kt.is_aktif,
            kt.created_at
          FROM tbl_katalog kt
          JOIN tbl_barang b ON kt.id_barang = b.id
          LEFT JOIN tbl_kategori ktg ON kt.id_kategori = ktg.id
          WHERE 1=1";

// Filter search
if (!empty($search)) {
    $query .= " AND (b.nama_barang LIKE '%$search%' OR b.kode_barang LIKE '%$search%')";
}

// Filter kategori
if (!empty($kategori_id) && $kategori_id != 'all') {
    $query .= " AND kt.id_kategori = '$kategori_id'";
}

$query .= " ORDER BY kt.created_at DESC";

$result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

// Ambil semua kategori untuk dropdown
$kategori_query = mysqli_query($mysqli, "SELECT * FROM tbl_kategori ORDER BY nama_kategori");
?>

<div class="container-fluid px-4">
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-store me-2 text-primary"></i> Katalog Barang
            </h1>
            <p class="text-muted mb-0">Kelola katalog untuk penjualan</p>
        </div>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKatalogModal">
                <i class="fas fa-plus me-1"></i> Tambah ke Katalog
            </button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                <i class="fas fa-tag me-1"></i> Tambah Kategori
            </button>
            <a href="?module=beranda" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="">
                <input type="hidden" name="module" value="katalog">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Cari nama barang atau kode..." 
                                   value="<?php echo htmlspecialchars($search); ?>">
                            <button class="btn btn-outline-primary" type="submit">
                                Cari
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="kategori">
                            <option value="all">Semua Kategori</option>
                            <?php while($ktg = mysqli_fetch_assoc($kategori_query)): ?>
                            <option value="<?php echo $ktg['id']; ?>" 
                                    <?php echo ($kategori_id == $ktg['id']) ? 'selected' : ''; ?>>
                                <?php echo $ktg['nama_kategori']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <a href="?module=katalog" class="btn btn-outline-secondary w-100">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- STATS -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted small">Total Item Katalog</h6>
                            <h4 class="mb-0"><?php echo mysqli_num_rows($result); ?></h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-box-open fa-2x text-primary opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL KATALOG -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary">
                <i class="fas fa-list me-2"></i> Daftar Katalog
            </h5>
        </div>
        <div class="card-body">
            <?php if(mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th class="text-center">Stok Tersedia</th>
                            <th>Harga Dasar</th>
                            <th>Harga Jual</th>
                            <th>Diskon</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        mysqli_data_seek($result, 0);
                        while($row = mysqli_fetch_assoc($result)): 
                            // Hitung harga setelah diskon
                            $harga_diskon = $row['harga_jual'] * (1 - ($row['diskon'] / 100));
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td>
                                <div class="fw-semibold"><?php echo $row['nama_barang']; ?></div>
                                <small class="text-muted"><?php echo $row['kode_barang']; ?></small>
                                <?php if(!empty($row['keterangan'])): ?>
                                <br><small class="text-muted"><?php echo $row['keterangan']; ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(!empty($row['nama_kategori'])): ?>
                                <span class="badge bg-info"><?php echo $row['nama_kategori']; ?></span>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-<?php echo ($row['stok_awal'] > 10) ? 'success' : (($row['stok_awal'] > 0) ? 'warning' : 'danger'); ?>">
                                    <?php echo $row['stok_awal']; ?>
                                </span>
                            </td>
                            <td class="text-muted">
                                Rp <?php echo format_rupiah($row['harga_dasar']); ?>
                            </td>
                            <td class="fw-bold text-primary">
                                Rp <?php echo format_rupiah($row['harga_jual']); ?>
                            </td>
                            <td>
                                <?php if($row['diskon'] > 0): ?>
                                <span class="badge bg-success"><?php echo $row['diskon']; ?>%</span>
                                <br>
                                <small class="text-success">
                                    Rp <?php echo format_rupiah($harga_diskon); ?>
                                </small>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($row['is_aktif'] == 1): ?>
                                <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                <span class="badge bg-secondary">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editKatalogModal"
                                            data-id="<?php echo $row['katalog_id']; ?>"
                                            data-nama="<?php echo htmlspecialchars($row['nama_barang']); ?>"
                                            data-harga="<?php echo $row['harga_jual']; ?>"
                                            data-diskon="<?php echo $row['diskon']; ?>"
                                            data-kategori="<?php echo $row['nama_kategori'] ?? ''; ?>"
                                            data-keterangan="<?php echo htmlspecialchars($row['keterangan'] ?? ''); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" 
                                            onclick="hapusKatalog(<?php echo $row['katalog_id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-store fa-4x text-muted opacity-25 mb-3"></i>
                <h5 class="text-muted mb-3">Katalog masih kosong</h5>
                <p class="text-muted mb-4">Tambahkan barang dari data barang ke katalog</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKatalogModal">
                    <i class="fas fa-plus me-1"></i> Tambah ke Katalog
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH KE KATALOG -->
<div class="modal fade" id="tambahKatalogModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i> Tambah ke Katalog
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="modules/katalog/tambah.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Barang</label>
                        <select class="form-select" name="id_barang" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php
                            $barang_query = mysqli_query($mysqli, 
                                "SELECT b.* FROM tbl_barang b 
                                 LEFT JOIN tbl_katalog k ON b.id = k.id_barang 
                                 WHERE k.id_barang IS NULL 
                                 ORDER BY b.nama_barang");
                            while($brg = mysqli_fetch_assoc($barang_query)):
                            ?>
                            <option value="<?php echo $brg['id']; ?>">
                                <?php echo $brg['nama_barang']; ?> 
                                (Stok: <?php echo $brg['stok'] ?? $brg['total_stok']; ?>)
                                - Rp <?php echo format_rupiah($brg['harga']); ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                        <small class="text-muted">Hanya barang yang belum ada di katalog</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="id_kategori">
                            <option value="">-- Tanpa Kategori --</option>
                            <?php
                            mysqli_data_seek($kategori_query, 0);
                            while($ktg = mysqli_fetch_assoc($kategori_query)):
                            ?>
                            <option value="<?php echo $ktg['id']; ?>">
                                <?php echo $ktg['nama_kategori']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Harga Jual *</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="harga_jual" 
                                   min="0" step="100" required>
                        </div>
                        <small class="text-muted">Harga yang akan ditampilkan di katalog</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Diskon (%)</label>
                        <input type="number" class="form-control" name="diskon" 
                               min="0" max="100" step="0.01" value="0">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH KATEGORI -->
<div class="modal fade" id="tambahKategoriModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-tag me-2"></i> Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="modules/katalog/tambah_kategori.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori *</label>
                        <input type="text" class="form-control" name="nama_kategori" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT KATALOG -->
<div class="modal fade" id="editKatalogModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i> Edit Item Katalog
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="modules/katalog/edit.php" method="POST">
                <input type="hidden" name="id" id="edit_katalog_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="edit_nama_barang" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="id_kategori" id="edit_kategori">
                            <option value="">-- Tanpa Kategori --</option>
                            <?php
                            mysqli_data_seek($kategori_query, 0);
                            while($ktg = mysqli_fetch_assoc($kategori_query)):
                            ?>
                            <option value="<?php echo $ktg['id']; ?>">
                                <?php echo $ktg['nama_kategori']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Harga Jual *</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="harga_jual" 
                                   id="edit_harga_jual" min="0" step="100" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Diskon (%)</label>
                        <input type="number" class="form-control" name="diskon" 
                               id="edit_diskon" min="0" max="100" step="0.01">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="is_aktif">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" 
                                  id="edit_keterangan" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi untuk modal edit
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editKatalogModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            document.getElementById('edit_katalog_id').value = button.getAttribute('data-id');
            document.getElementById('edit_nama_barang').value = button.getAttribute('data-nama');
            document.getElementById('edit_harga_jual').value = button.getAttribute('data-harga');
            document.getElementById('edit_diskon').value = button.getAttribute('data-diskon');
            document.getElementById('edit_keterangan').value = button.getAttribute('data-keterangan');
            
            // Set kategori
            const kategoriSelect = document.getElementById('edit_kategori');
            const kategoriValue = button.getAttribute('data-kategori');
            for(let i = 0; i < kategoriSelect.options.length; i++) {
                if(kategoriSelect.options[i].text === kategoriValue) {
                    kategoriSelect.selectedIndex = i;
                    break;
                }
            }
        });
    }
});

// Fungsi hapus
function hapusKatalog(id) {
    if(confirm('Apakah yakin ingin menghapus item dari katalog?')) {
        window.location.href = 'modules/katalog/hapus.php?id=' + id;
    }
}
</script>