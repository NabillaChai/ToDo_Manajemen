<?php
include "../config/koneksi.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $text        = trim($_POST['text'] ?? '');
    $notes       = trim($_POST['notes'] ?? '');
    $deadline    = trim($_POST['deadline'] ?? '');
    $status      = trim($_POST['status'] ?? 'todo');
    $created_at  = date('Y-m-d H:i:s');

    // mapping status ke done (biar nyambung dashboard lama)
    $done = ($status === 'done') ? 1 : 0;

    if ($text === '') {
        $error = "Judul tugas tidak boleh kosong.";
    } else {

$title       = mysqli_real_escape_string($conn, $text);
$description = mysqli_real_escape_string($conn, $notes);
$deadline    = mysqli_real_escape_string($conn, $deadline);
$status      = mysqli_real_escape_string($conn, $status);

$sql = "INSERT INTO todos (title, description, deadline, status, created_at)
        VALUES (
            '$title',
            '$description',
            " . ($deadline ? "'$deadline'" : "NULL") . ",
            '$status',
            '$created_at'
        )";

        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Gagal menyimpan: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Tugas</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
body{
    background:#f5f7fb;
    font-family:'Segoe UI',sans-serif;
}

/* NAVBAR */
.navbar-custom{
    background:#2d74c4;
    padding:16px 24px;
}

.navbar-custom h4{
    color:white;
    margin:0;
    font-weight:600;
}

/* CENTER */
.page-center{
    display:flex;
    justify-content:center;
    margin-top:40px;
}

/* CARD */
.form-card{
    background:white;
    border-radius:16px;
    padding:30px;
    width:100%;
    max-width:520px;
    border:1px solid #e3e6eb;
}

/* INPUT */
.form-control, .form-select{
    border-radius:10px;
    font-size:14px;
}

/* BUTTON */
.btn-primary-custom{
    background:#2d74c4;
    color:white;
    border:none;
    border-radius:10px;
    padding:10px;
    font-weight:600;
    width:100%;
}

.btn-primary-custom:hover{
    background:#1f5fa5;
}
</style>

</head>
<body>

<!-- NAVBAR -->
<div class="navbar-custom d-flex justify-content-between">
    <h4><i class="fa-solid fa-clipboard-list me-2"></i>Manajemen Proyek</h4>
    <a href="index.php" class="text-white text-decoration-none">Dashboard</a>
</div>

<div class="page-center">

<div class="form-card">

    <a href="index.php" class="text-muted text-decoration-none mb-3 d-inline-block">
        ← Kembali ke Dashboard
    </a>

    <h5 class="mb-4">Tambah Tugas Baru</h5>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <!-- Judul -->
        <div class="mb-3">
            <label class="form-label">Judul Tugas</label>
            <input type="text" name="text" class="form-control" placeholder="Masukkan judul tugas" required>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="notes" class="form-control" placeholder="Jelaskan detail tugas"></textarea>
        </div>

        <!-- Dibuat pada -->
        <div class="mb-3">
            <label class="form-label">Dibuat Pada</label>
            <input type="text" class="form-control" value="<?= date('d-m-Y H:i') ?>" disabled>
        </div>

        <!-- Deadline -->
        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" class="form-control">
        </div>

        <!-- Status -->
        <div class="mb-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="todo">To Do</option>
                <option value="progress">In Progress</option>
                <option value="done">Done</option>
            </select>
        </div>

        <!-- BUTTON -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom">
                <i class="fa-solid fa-floppy-disk me-1"></i> Tambah Tugas
            </button>
            <a href="index.php" class="btn btn-outline-secondary">Batal</a>
        </div>

    </form>

</div>
</div>

</body>
</html>