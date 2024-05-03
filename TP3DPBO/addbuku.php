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

$mainTitle = 'Tambah Buku';

$datagenre = null;
while ($listgenre = $genre->getResult()) {
    $id_genre = $listgenre['id_genre'];
    $nama_genre = $listgenre['nama_genre'];
    
    $datagenre .= "<option value='". $id_genre ."'>". $id_genre ." - ". $nama_genre ."</option>";
}

$datapeminjaman = null;
while ($listpeminjaman = $peminjaman->getResult()) {
    $id_peminjaman = $listpeminjaman['id_peminjaman'];
    $kode_peminjaman = $listpeminjaman['kode_peminjaman'];

    $datapeminjaman .= "<option value='". $id_peminjaman ."'>". $id_peminjaman ." - ". $kode_peminjaman ."</option>";
}

$dataanggota = null;
while ($listanggota = $anggota->getResult()) {
    $id_anggota = $listanggota['id_anggota'];
    $nama_anggota = $listanggota['nama_anggota'];

    $dataanggota .= "<option value='". $id_anggota ."'>". $id_anggota ." - ". $nama_anggota ."</option>";
}

if (isset($_POST['tambah'])) {
    if ($buku->addbuku($_POST) > 0) {
        echo "<script>
            alert('Data berhasil ditambah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambah!');
            document.location.href = 'index.php';
        </script>";
    }
}

$form = '<div class="col gx-2 gy-3 justify-content-center">
<form action="addbuku.php" method="post" role="form" id="form-add" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id">
    <div class="mb-3">
        <label for="foto_buku" class="form-label">Foto</label>
        <input class="form-control" type="file" id="foto_buku" name="foto_buku" required>
    </div>
    <div class="mb-3">
        <label for="judul_buku" class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul_buku" name="judul_buku" required>
    </div>
    <div class="mb-3">
        <label for="penulis_buku" class="form-label">Penulis buku</label>
        <input type="text" class="form-control" id="penulis_buku" name="penulis_buku" required>
    </div>
    <div class="mb-3">
        <label for="tahun_terbit_buku" class="form-label">Tahun terbit</label>
        <input type="text" class="form-control" id="tahun_terbit_buku" name="tahun_terbit_buku" required>
    </div>
    <div class="mb-3">
        <label for="status_buku" class="form-label">Status buku</label>
        <input type="text" class="form-control" id="status_buku" name="status_buku" required>
    </div>
    <div class="mb-3">
        <label for="genre" class="form-label">Genre</label>
        <select class="form-select" aria-label="Category" id="genre" name="genre" required>
            <option value="" selected disabled hidden>Pilih</option>'.
            $datagenre.'
        </select>
    </div>
    <div class="mb-3">
        <label for="peminjaman" class="form-label">Kode pinjam</label>
        <select class="form-select" aria-label="Category" id="peminjaman" name="peminjaman" required>
            <option value="" selected disabled hidden>Pilih</option>'.
            $datapeminjaman.'
        </select>
    </div>
    <div class="mb-3">
        <label for="anggota" class="form-label">Nama anggota</label>
        <select class="form-select" aria-label="Category" id="anggota" name="anggota" required>
            <option value="" selected disabled hidden>Pilih</option>'.
            $dataanggota.'
        </select>
    </div>

    <a href="index.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></a>
    <button type="submit" class="btn btn-primary text-white" name="tambah" id="tambah" form="form-add">Tambah</button>
</form>
</div>
';

$buku->close();
$genre->close();
$peminjaman->close();
$anggota->close();

$view = new Template('templates/skindataform.html');
$view->replace('DATA_TITLE', $mainTitle);
$view->replace('DATA_BUTTON', $btn);
$view->replace('FORM', $form);
$view->write();
