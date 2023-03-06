<?php

require_once __DIR__ . '/vendor/autoload.php';
require './functions/functions.php';

$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);

$kegiatan = query("SELECT * FROM kegiatan ORDER BY tanggal ASC");

$html = '
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Logbook Magang</title>
</head>
<body>
<h1>Logbook Magang</h1>
<table class="table table-dark table-striped" border="1" cellpadding="10" cellspacing="0">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama Kegiatan</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Foto</th>
          <th scope="col">Kegiatan</th>
        </tr>
      </thead>
      <tbody>';

$i = 1;
foreach ($kegiatan as $data) {
    $html .= '<tr>
            <td>' . $i++ . '</td>
            <td>' . $data['namaKegiatan'] . '</td>
            <td>' . $data['tanggal'] . '</td>
            <td><img src="./img/' . $data['foto'] . '"  height="60" width="80" style="object-fit: cover;" ></td>
            <td>' . $data['rincianKegiatan'] . '</td>
        </tr>';
}


$html .= '</tbody>
</table>      
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('logbook-magang.pdf', 'I');
