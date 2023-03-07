<?php

$conn = mysqli_connect('localhost', 'root', 'master123', 'phpdasar');
$jmlHalamanCari = 0;


function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah($data)
{
    global $conn;

    $nama = htmlspecialchars($data['namaKegiatan']);
    $tanggal = htmlspecialchars($data['tanggal']);
    $rincian = htmlspecialchars($data['rincian']);
    // $gambar = htmlspecialchars($data['gambar']);

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO kegiatan VALUES (null, '$nama', STR_TO_DATE('$tanggal', '%Y-%m-%d'), '$rincian', '$gambar')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;

    $id = $data['id'];
    $nama = htmlspecialchars($data['namaKegiatan']);
    $tanggal = htmlspecialchars($data['tanggal']);
    $rincian = htmlspecialchars($data['rincian']);
    $gambarLama = htmlspecialchars($data['gambarLama']);

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = " UPDATE kegiatan SET
        namaKegiatan = '$nama',
        tanggal = STR_TO_DATE('$tanggal', '%Y-%m-%d'),
        rincianKegiatan = '$rincian',
        foto = '$gambar'
        WHERE id = $id
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function hapus($id)
{
    global $conn;

    $query = "DELETE FROM kegiatan WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function upload()

{
    $namaFile = $_FILES['gambar']['name'];
    $size = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpname = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "
        <script>
            alert('Silahkan pilih gambar terlebi dahulu!');
        </script>
        ";
        return false;
    }

    $extensiValid = ['jpeg', 'jpg', 'png'];
    $extensi = explode('.', $namaFile);
    $extensi = strtolower(end($extensi));
    if (!in_array($extensi, $extensiValid)) {
        echo "
        <script>
            alert('File yang anda upload bukan tipe gambar');
        </script>
    ";
        return false;
    }

    if ($size > 2000000) {
        echo "
        <script>
            alert('File yang anda upload terlalu besar (max. 2MB)');
        </script>
    ";
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensi;

    move_uploaded_file($tmpname, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

function cari($keyword)
{

    $query = "SELECT * FROM kegiatan WHERE namaKegiatan LIKE '%$keyword%' ORDER BY tanggal DESC";

    return query($query);
}

function register($data)
{
    global $conn;

    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>
            alert('Username yang anda masukkan sudah terdaftar !');
        </script> ";
        return false;
    }


    if ($password !== $password2) {
        echo "
        <script>
            alert('Konfirmasi password tidak sesuai');
        </script> ";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user VALUES (null, '$username', '$password')");

    return mysqli_affected_rows($conn);
}
