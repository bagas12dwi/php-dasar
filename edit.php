<?php

session_start();

require './functions/functions.php';

if (!isset($_SESSION["user"])) {
    header("Location: ./login.php");
    exit;
}

$id = $_GET['id'];


$kegiatan = query("SELECT * FROM kegiatan WHERE id = $id")[0];

if (isset($_POST["submit"])) {

    if (ubah($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil Diedit!');
            document.location.href = './index.php';
        </script>
    ";
    } else {
        echo "
        <script>
            alert('Data Berhasil Diedit!');
            document.location.href = './index.php';
        </script>
    ";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Logbook</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
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

    <div class="container py-3">
        <h6>Edit Logbook</h6>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $kegiatan['id']; ?>">
                    <input type="hidden" name="gambarLama" value="<?= $kegiatan['foto']; ?>">
                    <div class="mb-3">
                        <label for="namaKegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="namaKegiatan" name="namaKegiatan" placeholder="Nama Kegiatan" value="<?= $kegiatan['namaKegiatan']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="tanggal" required value="<?= $kegiatan['tanggal']; ?>">

                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Foto Kegiatan</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" placeholder="gambar" required>
                    </div>
                    <div class="mb-3">
                        <label for="rincian" class="form-label">Rincian Kegiatan</label>
                        <textarea class="form-control" id="rincian" name="rincian" placeholder="rincian" required><?= $kegiatan['rincianKegiatan']; ?></textarea>
                    </div>
                    <a href="./" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-md-6">
                <h6>Gambar Sebelumnya : </h6>
                <img src="./img/<?= $kegiatan['foto']; ?>" width="100%" height="60%" style="object-fit: cover;" alt="">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>