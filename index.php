<?php
include "config/koneksi.php";

/* ======================
   AMBIL DATA TODO
====================== */
$query = mysqli_query($conn,"SELECT * FROM todos ORDER BY id DESC");
$todos = mysqli_fetch_all($query, MYSQLI_ASSOC);

$total = count($todos);

$done = 0;
foreach($todos as $t){
    if($t['status'] == 'Done') $done++;
}

$left = $total - $done;
$pct = $total ? round(($done/$total)*100) : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen Proyek</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
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

/* BUTTON */
.btn-dashboard{
    background:rgba(255,255,255,0.2);
    color:white;
    border-radius:10px;
}

.btn-add{
    background:#2d74c4;
    color:white;
    border-radius:12px;
    padding:10px 18px;
}

/* CARD */
.task-card{
    background:white;
    border-radius:16px;
    padding:20px;
    border:1px solid #e3e6eb;
    position:relative;
    height:100%;
    transition:0.2s;
    cursor:pointer;
}

.task-card:hover{
    transform:translateY(-4px);
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
}

.task-title{
    font-weight:600;
    font-size:18px;
}

/* STATUS BADGE */
.badge-status{
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    display:inline-block;
}

.done{
    background:#d1f2e1;
    color:#1e7e34;
}

.todo{
    background:#e9ecef;
    color:#6c757d;
}

.progress-status{
    background:#d0e2ff;
    color:#2d74c4;
}

/* ICON */
.icon-status{
    position:absolute;
    top:20px;
    right:20px;
    font-size:18px;
}

/* DATE */
.task-date{
    font-size:14px;
    color:#6c757d;
}
</style>

</head>
<body>

<!-- NAVBAR -->
<div class="navbar-custom d-flex justify-content-between align-items-center">
    <h4><i class="fa-solid fa-clipboard-list me-2"></i>Manajemen Proyek</h4>
    <button class="btn btn-dashboard">Dashboard</button>
</div>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Daftar Tugas</h4>
            <p class="text-muted">Kelola dan pantau semua tugas proyek Anda</p>
        </div>

        <a href="action/tambah_tugas.php" class="btn btn-add">
            <i class="fa-solid fa-plus me-2"></i>Tambah Tugas
        </a>
    </div>

    <!-- LIST -->
    <div class="row g-4">

        <?php if($total == 0): ?>
            <div class="text-center mt-5">
                <h4>Tidak ada tugas 🎉</h4>
                <p class="text-muted">Tambahkan tugas pertama kamu</p>
            </div>
        <?php else: ?>

        <?php foreach($todos as $t): ?>

        <div class="col-md-4">
            <a href="action/detail_tugas.php?id=<?= $t['id'] ?>" style="text-decoration:none; color:inherit;">
            <div class="task-card">

                <!-- ICON -->
                <div class="icon-status">
                    <?php if($t['status'] == 'Done'): ?>
                        <i class="fa-solid fa-circle-check text-success"></i>
                    <?php else: ?>
                        <i class="fa-regular fa-circle text-secondary"></i>
                    <?php endif; ?>
                </div>

                <!-- TITLE -->
                <div class="task-title mb-3">
                    <?= htmlspecialchars($t['title']) ?>
                </div>

                <!-- STATUS -->
                <?php if($t['status'] == 'Done'): ?>
                    <span class="badge-status done">Done</span>
                <?php elseif($t['status'] == 'In Progress'): ?>
                    <span class="badge-status progress-status">In Progress</span>
                <?php else: ?>
                    <span class="badge-status todo">To Do</span>
                <?php endif; ?>

                <!-- INFO -->
                <div class="task-date mt-2">
                    <?= htmlspecialchars($t['category']) ?> | <?= htmlspecialchars($t['priority']) ?>
                </div>

                <!-- ACTION -->
                <div class="mt-3 d-flex gap-2">
                    <a href="action/toggle.php?id=<?= $t['id'] ?>" 
                       onclick="event.stopPropagation()" 
                       class="btn btn-sm btn-outline-primary">✔</a>

                    <a href="action/hapus.php?id=<?= $t['id'] ?>" 
                       onclick="event.stopPropagation(); return confirm('Hapus tugas ini?')" 
                       class="btn btn-sm btn-outline-danger">✕</a>
                </div>

            </div>
            </a>
        </div>

        <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <!-- FOOTER -->
    <div class="mt-4">
        <a href="action/clear.php" 
           onclick="return confirm('Hapus semua tugas selesai?')" 
           class="btn btn-danger">
           Hapus selesai
        </a>
    </div>

</div>

</body>
</html>