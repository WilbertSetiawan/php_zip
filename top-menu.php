<?php

require_once 'config/database.php';

// Ambil data user login
$id_user = $_SESSION['id_user'] ?? 0;

$query = mysqli_query(
    $mysqli,
    "SELECT id, nama, foto, hak_akses 
     FROM tbl_users 
     WHERE id = '$id_user' 
     LIMIT 1"
) or die(mysqli_error($mysqli));

$data = mysqli_fetch_assoc($query);

// Fallback data
$nama      = $data['nama'] ?? 'Administrator';
$hak_akses = $data['hak_akses'] ?? 'Admin';
$foto      = empty($data['foto']) ? 'user-default.png' : $data['foto'];
?>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white text-nowrap"
       href="#"
       id="userDropdown"
       role="button"
       data-bs-toggle="dropdown"
       aria-expanded="false">

        <!-- Foto User -->
        <img src="assets/img/<?php echo $foto; ?>"
             alt="User"
             width="32"
             height="32"
             class="rounded-circle border border-light">

        <!-- Nama User -->
        <span class="d-none d-md-inline fw-semibold">
            <?php echo htmlspecialchars($nama); ?>
        </span>
    </a>

    <!-- Dropdown -->
    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
        aria-labelledby="userDropdown"
        style="min-width: 220px;">

        <!-- Header User -->
        <li class="px-3 py-3 text-center bg-light">
            <img src="images/user/<?php echo $foto; ?>"
                 alt="User"
                 width="80"
                 height="80"
                 class="rounded-circle mb-2 border">

            <div class="fw-bold text-dark">
                <?php echo htmlspecialchars($nama); ?>
            </div>
            <small class="text-muted">
                <?php echo htmlspecialchars($hak_akses); ?>
            </small>
        </li>

        <li><hr class="dropdown-divider"></li>

        <!-- Action -->
        <li class="px-3 pb-2 d-flex justify-content-between gap-2">
            <a href="?modules=profil"
               class="btn btn-sm btn-outline-primary w-100">
                Profil
            </a>

            <button type="button"
                    class="btn btn-sm btn-danger w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#logout">
                Logout
            </button>
        </li>
    </ul>
</li>