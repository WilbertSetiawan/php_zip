<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa fa-home me-2 text-primary"></i>Beranda
        </h1>
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="?modules=beranda" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
    <div class="alert alert-info border-0 shadow-sm mb-4" role="alert">
        <i class="fa fa-info-circle me-2"></i>
         Selamat datang <strong><?php echo $data['nama']; ?></strong> di Gusti Berkah jaya.
    </div>
    <!-- Di card Barang -->
     <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm border-start border-primary border-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col me-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 small">
                            Barang
                        </div> 
                           <!-- Di card Barang -->
                            <a href="main.php?module=input_barang" class="btn btn-sm btn-primary mt-3 w-100">
                                <i class="fa fa-plus-circle me-1"></i> Input Barang Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>  

        <!-- Card Katalog -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm border-start border-success border-4 h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1 small">
                                Katalog</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Kelola Katalog Barang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-store fa-2x text-gray-300 opacity-25"></i>
                        </div>
                    </div>
                    <a href="main.php?module=katalog" class="btn btn-sm btn-success mt-3 w-100">
                        <i class="fa fa-book-open me-1"></i> Buka Katalog
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm border-start border-warning border-4 h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 small">
                                Satuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Kelola Satuan barang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-circle-o fa-2x text-gray-300 opacity-25"></i>
                        </div>
                    </div>
                    <a href="?modules=satuan" class="btn btn-sm btn-warning mt-3 w-100">Buka Satuan</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Petunjuk Penggunaan</h6>
                </div>
                <div class="card-body small">
                    <ul>
    <li>Gunakan menu <strong>3 Kategori diatas</strong> untuk mengelola kategori, Katalog, dan satuan.</li>
    <li>Gunakan menu <strong>Data Barang</strong> untuk manajemen stok produk.</li>
    <li>Gunakan menu <strong>Penjualan</strong> untuk mencatat transaksi keluar.</li>
</ul>
                </div>
            </div>
        </div>
    </div>
</div>