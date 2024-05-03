<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Buku.php');
include('classes/Genre.php');
include('classes/Anggota.php');
include('classes/Peminjaman.php');
include('classes/Template.php');

$buku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$genre = new Genre($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$peminjaman = new Peminjaman($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$anggota = new Anggota($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$buku->open();
$genre->open();
$peminjaman->open();
$anggota->open();

$buku->getbuku();
$genre->getgenre();
$peminjaman->getpeminjaman();
$anggota->getanggota();

$mainTitle = 'Update Buku';
 
$datagenre = null;
$datapeminjaman = null;
$dataanggota = null;
$form = null;

if (isset($_GET['id_update'])) {
    $id = $_GET['id_update'];
    $buku->getbukuById($id);
    $result = $buku->getresult();
    
    while($data = $genre->getResult()){
        $datagenre .= '<option value="'.$data['id_genre'].'" '.($data['id_genre'] == $result['id_genre'] ? "selected" : "").'>'.$data['nama_genre'].'</option>';
    }
    
    while($data = $peminjaman->getResult()){
        $datapeminjaman .= '<option value="'.$data['id_peminjaman'].'" '.($data['id_peminjaman'] == $result['id_peminjaman'] ? "selected" : "").'>'.$data['kode_peminjaman'].'</option>';
    }
    
    while($data = $anggota->getResult()){
        $dataanggota .= '<option value="'.$data['id_anggota'].'" '.($data['id_anggota'] == $result['id_anggota'] ? "selected" : "").'>'.$data['nama_anggota'].'</option>';
    }

    $form = '<div class="col gx-2 gy-3 justify-content-center">
    <form action="" method="POST" role="form" id="form-add" enctype="multipart/form-data">
        <input type="hidden" name="id_update" id="id_update" value="'.$result['id_buku'].'">
        <div class="mb-3">
            <label for="foto_buku" class="form-label">Foto</label><br>
            <img src="assets/images/'.$result['foto_buku'].'" alt="" width="120px"><br>
            <input type="hidden" name="foto_lama" id="foto_lama" value="'.$result['foto_buku'].'">
            <input class="form-control" type="file" id="foto_buku" name="foto_buku">
        </div>
        <div class="mb-3">
            <label for="judul_buku" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="'.$result['judul_buku'].'" required>
        </div>
        <div class="mb-3">
            <label for="penulis_buku" class="form-label">Penulis buku</label>
            <input type="text" class="form-control" id="penulis_buku" name="penulis_buku" value="'.$result['penulis_buku'].'" required>
        </div>
        <div class="mb-3">
            <label for="tahun_terbit_buku" class="form-label">Tahun terbit</label>
            <input type="text" class="form-control" id="tahun_terbit_buku" name="tahun_terbit_buku" value="'.$result['tahun_terbit_buku'].'" required>
        </div>
        <div class="mb-3">
            <label for="status_buku" class="form-label">Status buku</label>
            <input type="text" class="form-control" id="status_buku" name="status_buku" value="'.$result['status_buku'].'" required>
        </div>
        <div class="mb-3">
            <label for="id_genre" class="form-label">Genre</label>
            <select class="form-select" aria-label="Category" id="id_genre" name="id_genre" required>
                '.$datagenre.'
            </select>
        </div>
        <div class="mb-3">
            <label for="id_peminjaman" class="form-label">Kode pinjam</label>
            <select class="form-select" aria-label="Category" id="id_peminjaman" name="id_peminjaman" required>
                '.$datapeminjaman.'
            </select>
        </div>
        <div class="mb-3">
            <label for="id_anggota" class="form-label">Nama anggota</label>
            <select class="form-select" aria-label="Category" id="id_anggota" name="id_anggota" required>
                '.$dataanggota.'
            </select>
        </div>
    
        <a href="index.php"><button type="button" class="btn btn-secondary">Cancel</button></a>
        <button type="submit" class="btn btn-primary text-white" name="submit" id="submit" form="form-add">Update</button>
    </form>
    </div>
    ';
    if (isset($_POST['submit'])) {
        if ($buku->updatebuku($id, $_POST, $_FILES) > 0) {
            echo "<script>
            alert('Data berhasil diubah!');
            document.location.href = 'detail.php?id=$id';
            </script>";
        } else {
            echo "<script>
            alert('Data gagal diubah!');
            document.location.href = 'index.php';
            </script>";
        }
    }
}

$buku->close();
$genre->close();
$peminjaman->close();
$anggota->close();

$view = new Template('templates/skindataform.html');
$view->replace('DATA_TITLE', $mainTitle);
$view->replace('FORM', $form);
$view->write();
