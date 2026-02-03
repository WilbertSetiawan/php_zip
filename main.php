<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Gusti Berkah Jaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Source Sans Pro', sans-serif; background-color: #f4f6f9; }
        .main-header { background-color: #3c8dbc; padding: 2px; color: white; }
        .sidebar { min-height: 100vh; background: #222d32; color: #fff; }
        .content-wrapper { padding: 20px; }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <header class="main-header d-flex justify-content-between align-items-center px-3 shadow-sm">
            <a href="?modules=beranda" class="text-decoration-none text-white d-flex align-items-center">
                <img src="assets/img/logo-penjualan.png" alt="logo" height="80" class="me-2">
                <span class="fs-3 fw-bold" style="font-family:'Lucida Handwriting', sans-serif; font-style: italic;">
                Gusti Berkah Jaya
                 </span>
            </a>
            
            <div class="d-flex align-items-center">
                <ul class="navbar-nav">
                    <?php include "top-menu.php"; ?>
                </ul>
            </div>
        </header>

        <div class="row g-0">
            <aside class="col-md-2 sidebar d-none d-md-block">
                <div class="p-3">
                    <?php include "sidebar-menu.php"; ?>
                </div>
            </aside>

            <main class="col-md-10 content-wrapper">
                <?php include "content.php"; ?>
            </main>
        </div>

        <div class="modal fade" id="logout" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-sign-out-alt"></i> Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin logout?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <a href="logout.php" class="btn btn-danger">Ya, Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>