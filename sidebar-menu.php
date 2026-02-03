<ul class="nav flex-column sidebar-menu">
    <li class="nav-header text-uppercase small text-white-50 px-3 py-2">
    MAIN MENU
</li> <li class="nav-item">
        <a class="nav-link active d-flex align-items-center text-white" href="?modules=beranda"> <i class="fa fa-home me-2"></i> <span>Beranda</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link d-flex align-items-center text-white justify-content-between" 
           data-bs-toggle="collapse" 
           href="#masterDataMenu" 
           role="button" 
           aria-expanded="false">
            <div>
                <i class="fa fa-file-text me-2"></i> <span>Master Data</span>
            </div>
            <i class="fa fa-angle-left transition-icon"></i> </a>
        
        <div class="collapse" id="masterDataMenu">
            <ul class="nav flex-column ms-3 small">
                <li class="nav-item">
                    <a class="nav-link text-white-50" href="?modules=kategori">
                        <i class="fa fa-circle-o me-2"></i> Kategori </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white-50" href="?modules=satuan">
                        <i class="fa fa-circle-o me-2"></i> Satuan </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link d-flex align-items-center text-white" href="?modules=barang"> <i class="fa fa-folder me-2"></i> <span>Data Barang</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link d-flex align-items-center text-white" href="?modules=penjualan"> <i class="fa fa-file-text me-2"></i> <span>Penjualan</span>
        </a>
    </li>
</ul>

<style>
    /* Tambahan CSS agar sidebar terlihat lebih modern */
    .sidebar-menu .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }
    .nav-link[aria-expanded="true"] .transition-icon {
        transform: rotate(-90deg);
        transition: 0.3s;
    }
    .nav-link .transition-icon {
        transition: 0.3s;
    }
</style>