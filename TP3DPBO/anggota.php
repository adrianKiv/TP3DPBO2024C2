<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Buku.php');
include('classes/Genre.php');
include('classes/Anggota.php');
include('classes/Peminjaman.php');
include('classes/Template.php');

$anggota = new Anggota($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$anggota->open();
$anggota->getanggota();

// cari anggota
if (isset($_POST['btn-cari'])) {
    // methode mencari data anggota
    $anggota->searchanggota($_POST['cari']);
}
else {
    if(isset($_POST['asc'])){
        $anggota->anggotaAsc();    
    }
    else if(isset($_POST['desc'])){
        $anggota->anggotaDesc();    
    }
    else if(isset($_POST['default'])){
        $anggota->getanggota();    
    }
}

$mainTitle = 'Anggota';

if (!isset($_GET['update'])) {
    if (isset($_POST['tambah'])) {
        if ($anggota->addanggota($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'anggota.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'anggota.php';
            </script>";
        }
    }
    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');



$formtambah = '<div class="col gx-2 gy-3 justify-content-center">
<form action="anggota.php" method="post" role="form" id="form-add">
    <input type="hidden" name="id" id="id">
    <div class="mb-3">
        <label for="nama_anggota" class="form-label">Nama Anggota</label>
        <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" required>
    </div>
    <div class="mb-3">
        <label for="alamat_anggota" class="form-label">Alamat Anggota</label>
        <input type="text" class="form-control" id="alamat_anggota" name="alamat_anggota" required>
    </div>
    <div class="mb-3">
        <label for="no_telpon_anggota" class="form-label">No Telpon Anggota</label>
        <input type="text" class="form-control" id="no_telpon_anggota" name="no_telpon_anggota" required>
    </div>
    <div class="mb-3">
        <label for="email_anggota" class="form-label">Email Anggota</label>
        <input type="text" class="form-control" id="email_anggota" name="email_anggota" required>
    </div>

    <a href="anggota.php"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button></a>
    <button type="submit" class="btn btn-primary text-white" name="tambah" id="tambah" form="form-add">tambah</button>
</form>
</div>
';

$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Anggota</th>
<th scope="row">Alamat Anggota</th>
<th scope="row">No Telpon Anggota</th>
<th scope="row">Email Anggota</th>
<th scope="row">Aksi</th>
</tr>';

$data = null;
$no = 1;
$formLabel = 'Anggota';

while ($div = $anggota->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_anggota'] . '</td>
    <td>' . $div['alamat_anggota'] . '</td>
    <td>' . $div['no_telpon_anggota'] . '</td>
    <td>' . $div['email_anggota'] . '</td>
    <td style="font-size: 22px;">
        <a href="anggota.php?update=' . $div['id_anggota'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="anggota.php?hapus=' . $div['id_anggota'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['update'])) {
    $id = $_GET['update'];
    if ($id > 0) {
        if (isset($_POST['update'])) {
            if ($anggota->updateanggota($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'anggota.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'anggota.php';
            </script>";
            }
        }

        $anggota->getanggotaById($id);
        $row = $anggota->getResult();

        $formupdate = '<div class="col gx-2 gy-3 justify-content-center">
        <form action="" method="post" role="form" id="form-add">
            <input type="hidden" name="id_update" id="id_update">
            <div class="mb-3">
                <label for="nama_anggota" class="form-label">Nama Anggota</label>
                <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" value="'.$row['nama_anggota'].'" required>
            </div>
            <div class="mb-3">
            <label for="alamat_anggota" class="form-label">Alamat Anggota</label>
            <input type="text" class="form-control" id="alamat_anggota" name="alamat_anggota" value="'.$row['alamat_anggota'].'" required>
            </div>
            <div class="mb-3">
                <label for="no_telpon_anggota" class="form-label">No Telpon Anggota</label>
                <input type="text" class="form-control" id="no_telpon_anggota" name="no_telpon_anggota" value="'.$row['no_telpon_anggota'].'" required>
            </div>
            <div class="mb-3">
                <label for="email_anggota" class="form-label">Email Anggota</label>
                <input type="text" class="form-control" id="email_anggota" name="email_anggota" value="'.$row['email_anggota'].'" required>
            </div>

            <a href="anggota.php"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button></a>
            <button type="submit" class="btn btn-primary text-white" name="update" id="update" form="form-add">update</button>
        </form>
        </div>
        ';

        $dataUpdate = $row['nama_anggota'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($anggota->deleteanggota($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'anggota.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'anggota.php';
            </script>";
        }
    }
}

$anggota->close();

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
