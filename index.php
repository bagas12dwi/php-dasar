<?php
session_start();
require './functions/functions.php';

global $jmlHalamanCari;

if (!isset($_SESSION["user"])) {
  header("Location: ./login.php");
  exit;
}

$id = $_SESSION['user']['id'];
$user = query("SELECT * FROM user WHERE id = $id")[0];

$jmlDataPerHalaman = 10;
$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$jmlData = count(query("SELECT * FROM kegiatan"));
$awalData = ($jmlDataPerHalaman * $halamanAktif) - $jmlDataPerHalaman;
$jmlHalaman = ceil($jmlData / $jmlDataPerHalaman);
$kegiatan = query("SELECT * FROM kegiatan ORDER BY tanggal DESC LIMIT $awalData, $jmlDataPerHalaman");

if (isset($_POST['cari'])) {
  $keyword = $_POST['keyword'];
  $kegiatan = cari($_POST['keyword']);
}


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logbook MAGANG 1</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./">Home</a>
          </li>
        </ul>
        <form class="d-flex" role="search" method="POST" action="">
          <input class="form-control me-2" type="search" name="keyword" id="keyword" placeholder="Cari Nama Kegiatan" aria-label="Search">
          <button class="btn btn-outline-success" name="cari">Search</button>
        </form>
        <ul class="navbar-nav">
          <li class="nav-item dropdown mx-3">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle me-2"></i><?= $user['username']; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" style="width: fit-content;">
              <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- content -->
  <div class="container py-3">
    <div class="row align-items-center justify-content-between">
      <div class="col">
        <div class="d-flex align-items-center">
          <h4 class="m-0">Log Book Magang</h4>
        </div>
      </div>
      <div class="col-auto">
        <div class="d-flex align-items-center">
          <a href="./cetak.php" class="btn btn-success me-3" target="_blank"><i class="bi bi-printer-fill"></i> Cetak</a>
          <a href="./tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Tambahkan Data</a>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
    </div>
    <div id="container">
      <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Kegiatan</th>
            <th scope="col">Hari, Tanggal</th>
            <th scope="col">Foto</th>
            <th scope="col">Kegiatan</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($kegiatan as $data) : ?>
            <tr>
              <th scope="row"><?= $i; ?></th>
              <td><?= $data['namaKegiatan']; ?></td>
              <td><?= $data['tanggal']; ?></td>
              <td><img src="./img/<?= $data['foto']; ?>" height="60" width="80" style="object-fit: cover;" alt=""></td>
              <td><?= $data['rincianKegiatan']; ?></td>
              <td>
                <div class="d-flex">
                  <a href="./hapus.php?id=<?= $data['id']; ?>" class="btn btn-danger me-3" onclick="return confirm('Apakah anda yakin menghapus data kegiatan <?= $data['namaKegiatan'] ?> ?');"><i class="bi bi-trash"></i> Hapus</a>
                  <a href="./edit.php?id=<?= $data['id']; ?> " class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                </div>
              </td>
            </tr>
            <?php $i++; ?>
          <?php endforeach; ?>
      </table>
      <?php if (!isset($_POST['cari'])) : ?>
        <nav aria-label="Page mt-3 navigation example">
          <ul class="pagination justify-content-end">
            <?php if ($halamanAktif > 1) : ?>
              <li class="page-item">
                <a class="page-link" href=".?halaman=<?= $halamanAktif - 1 ?>">&laquo;</a>
              </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $jmlHalaman; $i++) : ?>
              <?php
              if ($i == $halamanAktif) : ?>
                <li class="page-item active"><a class="page-link" href="?halaman=<?= $i ?>"><?= $i; ?></a></li>
              <?php else : ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $i ?>"><?= $i; ?></a></li>
              <?php endif; ?>

            <?php endfor; ?>
            <?php if ($halamanAktif < $jmlHalaman) : ?>
              <li class="page-item">
                <a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?>">&raquo;</a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>

  </div>
  <!-- <script src="./js/jquery.js"></script> -->

  <script src="./js/jquery.js"></script>
  <script src="./js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>