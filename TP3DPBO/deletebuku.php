<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Buku.php');
include('classes/Genre.php');
include('classes/Anggota.php');
include('classes/Peminjaman.php');
include('classes/Template.php');

$buku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$buku->open();
$buku->getbuku();

if (isset($_GET['id_delete'])) {
    $id = $_GET['id_delete'];
    if ($id > 0) {
        if ($buku->deletebuku($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>";
        }
    }
}

$buku->close();
