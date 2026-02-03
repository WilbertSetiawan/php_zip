<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Gusti Berkah Jaya</title>    
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Gusti Berkah Jaya">
    <meta name="author" content="Wilbert">

    <link rel="shortcut icon" href="assets/img/favicon.png">

    <!-- Bootstrap 5.3.8 -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="assets/plugins/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
        }
        .login-logo img {
            height: 50px;
        }
    </style>
</head>

<body>

<div class="card login-card">
    <div class="card-body p-3">

        <!-- Logo -->
        <div class="text-center login-logo mb-4">
            <img src="assets/img/logo-penjualan.png" alt="Logo">
            <h4 class="mt-2 text-primary fw-bold">Administratif Web</h4>
        </div>

        <!-- Alert -->
        <?php
        if (!empty($_GET['alert'])) {

            if ($_GET['alert'] == 1) {
                echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-times-circle"></i> Gagal Login!</strong><br>
                    Email atau Password salah, silakan cek kembali.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
            }

            elseif ($_GET['alert'] == 2) {
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-check-circle"></i> Sukses!</strong><br>
                    Anda telah berhasil logout.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
            }
        }
        ?>

        <p class="text-center mb-4">
            <i class="fa fa-user"></i> Silahkan Login
        </p>

        <!-- Form -->
        <form action="login_check.php" method="POST">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                    <input type="text" name="email" class="form-control" placeholder="Email" autocomplete="off" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" name="login" class="btn btn-primary btn-lg">
                    <i class="fa fa-sign-in"></i> Login
                </button>
            </div>

        </form>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
