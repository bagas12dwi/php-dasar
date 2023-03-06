<?php
session_start();
require '../functions/functions.php';

$keyword = $_GET['keyword'];

$query = "SELECT * FROM kegiatan WHERE namaKegiatan LIKE '%$keyword%' ORDER BY tanggal DESC";

$kegiatan = query($query);
?>
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