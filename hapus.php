<?php
session_start();

require './functions/functions.php';

if (!isset($_SESSION["user"])) {
    header("Location: ./login.php");
    exit;
}

$id = $_GET["id"];

if (hapus($id) > 0) {
    echo "
        <script>
            alert('Data Berhasil Dihapus!');
            document.location.href = './index.php';
        </script>
    ";
} else {
    echo "
    <script>
            alert('Data Gagal Dihapus!');
            document.location.href = './index.php';
        </script>
    ";
}
