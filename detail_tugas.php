<?php
include "../config/koneksi.php";

// ambil id dari URL
$id = $_GET['id'] ?? 0;

// ambil data dari database
$query = mysqli_query($conn, "SELECT * FROM todos WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

// cek kalau data tidak ada
if (!$data) {
    echo "Data tidak ditemukan";
    exit;
}

// mapping data
$judul     = $data['title'];
$status    = $data['status'];
$deadline  = $data['deadline'] ? date('d F Y', strtotime($data['deadline'])) : '-';
$dibuat    = date('d F Y', strtotime($data['created_at']));
$deskripsi = $data['description'] ?: '-';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Tugas</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background-color: #f4f6f9;
    font-family: 'Segoe UI', sans-serif;
}

/* NAVBAR */
.navbar-custom {
    background-color: #1f4e79;
}
.navbar-custom .navbar-brand,
.navbar-custom .nav-link {
    color: white !important;
}

/* CARD */
.card-custom {
    border-radius: 10px;
    border: 1px solid #ddd;
}

/* STATUS */
.badge-status {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 14px;
}

.todo { background:#e9ecef; color:#6c757d; }
.progress { background:#d0e2ff; color:#2d74c4; }
.done { background:#d1f2e1; color:#1e7e34; }

/* DIVIDER */
.section-divider {
    border-top: 1px solid #e0e0e0;
    margin: 20px 0;
}

/* BUTTON */
.btn-edit {
    background-color: #1f4e79;
    color: white;
    width: 100%;
}
.btn-delete {
    border: 1px solid red;
    color: red;
}

/* MODAL */
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: none;
    z-index: 999;
}

.modal-custom {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 350px;
    z-index: 1000;
    display: none;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom px-4">
    <a class="navbar-brand" href="#">
        <i class="bi bi-clipboard me-2"></i> Manajemen Proyek
    </a>
    <div class="ms-auto">
        <a href="../index.php" class="nav-link">Dashboard</a>
    </div>
</nav>

<div class="container mt-4">

    <!-- BACK -->
    <a href="../index.php" class="text-decoration-none text-dark mb-3 d-inline-block">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>

    <!-- CARD -->
    <div class="card card-custom p-4">

        <!-- JUDUL -->
        <h5><?= htmlspecialchars($judul) ?></h5>

        <!-- STATUS -->
        <div class="d-flex align-items-center mt-2 mb-3">
            <i class="bi bi-clock me-2 text-primary"></i>

            <?php
            $statusClass = 'todo';
            if($status == 'Done') $statusClass = 'done';
            elseif($status == 'In Progress') $statusClass = 'progress';
            ?>

            <span class="badge-status <?= $statusClass ?>">
                <?= $status ?>
            </span>
        </div>

        <!-- INFO -->
        <div class="row">
            <div class="col-md-6">
                <small class="text-muted"><i class="bi bi-calendar-event"></i> Deadline</small>
                <div><?= $deadline ?></div>
            </div>
            <div class="col-md-6">
                <small class="text-muted"><i class="bi bi-calendar"></i> Dibuat pada</small>
                <div><?= $dibuat ?></div>
            </div>
        </div>

        <div class="section-divider"></div>

        <!-- DESKRIPSI -->
        <h6>Deskripsi</h6>
        <p class="text-muted"><?= htmlspecialchars($deskripsi) ?></p>

        <div class="section-divider"></div>

        <!-- BUTTON -->
        <div class="d-flex gap-3">
            <a href="edit_tugas.php?id=<?= $id ?>" class="btn btn-edit">
                <i class="bi bi-pencil"></i> Edit Tugas
            </a>

            <button class="btn btn-delete" onclick="openModal()">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </div>

    </div>
</div>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

<!-- MODAL -->
<div class="modal-custom" id="modalHapus">
    <div class="fw-bold mb-2">Konfirmasi Hapus</div>
    <p style="font-size:14px;">
        Apakah yakin ingin menghapus tugas ini?
    </p>

    <div class="d-flex gap-2">
        <a href="hapus.php?id=<?= $id ?>" class="btn btn-danger w-50">Ya, Hapus</a>
        <button class="btn btn-secondary w-50" onclick="closeModal()">Batal</button>
    </div>
</div>

<script>
function openModal(){
    document.getElementById("overlay").style.display = "block";
    document.getElementById("modalHapus").style.display = "block";
}

function closeModal(){
    document.getElementById("overlay").style.display = "none";
    document.getElementById("modalHapus").style.display = "none";
}
</script>

</body>
</html>