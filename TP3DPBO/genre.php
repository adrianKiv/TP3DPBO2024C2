<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Buku.php');
include('classes/Genre.php');
include('classes/Anggota.php');
include('classes/Peminjaman.php');
include('classes/Template.php');

$genre = new Genre($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$genre->open();
$genre->getgenre();

// cari genre
if (isset($_POST['btn-cari'])) {
    // methode mencari data genre
    $genre->searchgenre($_POST['cari']);
}
else {
    if(isset($_POST['asc'])){
        $genre->genreAsc();    
    }
    else if(isset($_POST['desc'])){
        $genre->genreDesc();    
    }
    else if(isset($_POST['default'])){
        $genre->getgenre();    
    }
}

$mainTitle = 'Genre';

if (!isset($_GET['update'])) {
    if (isset($_POST['tambah'])) {
        if ($genre->addgenre($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'genre.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'genre.php';
            </script>";
        }
    }
    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');



$formtambah = '<div class="col gx-2 gy-3 justify-content-center">
<form action="genre.php" method="post" role="form" id="form-add">
    <input type="hidden" name="id" id="id">
    <div class="mb-3">
        <label for="nama_genre" class="form-label">Nama Genre</label>
        <input type="text" class="form-control" id="nama_genre" name="nama_genre" required>
    </div>

    <a href="genre.php"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button></a>
    <button type="submit" class="btn btn-primary text-white" name="tambah" id="tambah" form="form-add">tambah</button>
</form>
</div>
';

$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Genre</th>
<th scope="row">Aksi</th>
</tr>';

$data = null;
$no = 1;
$formLabel = 'Genre';

while ($div = $genre->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_genre'] . '</td>
    <td style="font-size: 22px;">
        <a href="genre.php?update=' . $div['id_genre'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="genre.php?hapus=' . $div['id_genre'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['update'])) {
    $id = $_GET['update'];
    if ($id > 0) {
        if (isset($_POST['update'])) {
            if ($genre->updategenre($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'genre.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'genre.php';
            </script>";
            }
        }

        $genre->getgenreById($id);
        $row = $genre->getResult();

        $formupdate = '<div class="col gx-2 gy-3 justify-content-center">
        <form action="" method="post" role="form" id="form-add">
            <input type="hidden" name="id_update" id="id_update">
            <div class="mb-3">
                <label for="nama_genre" class="form-label">Nama Genre</label>
                <input type="text" class="form-control" id="nama_genre" name="nama_genre" value="'.$row['nama_genre'].'" required>
            </div>

            <a href="genre.php"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button></a>
            <button type="submit" class="btn btn-primary text-white" name="update" id="update" form="form-add">update</button>
        </form>
        </div>
        ';

        $dataUpdate = $row['nama_genre'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($genre->deletegenre($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'genre.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'genre.php';
            </script>";
        }
    }
}

$genre->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TABEL', $data);

$form = null;
if (!isset($_GET['update'])) {
    $form = $formtambah;
}
else{
    $form = $formupdate;
}
$view->replace('FORM', $form);

$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->write();
