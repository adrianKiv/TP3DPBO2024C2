<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Buku.php');
include('classes/Genre.php');
include('classes/Anggota.php');
include('classes/Peminjaman.php');
include('classes/Template.php');

$peminjaman = new Peminjaman($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$peminjaman->open();
$peminjaman->getpeminjaman();

// cari buku
if (isset($_POST['btn-cari'])) {
    // methode mencari data buku
    $peminjaman->searchpeminjaman($_POST['cari']);
}
else {
    if(isset($_POST['asc'])){
        $peminjaman->peminjamanAsc();    
    }
    else if(isset($_POST['desc'])){
        $peminjaman->peminjamanDesc();    
    }
    else if(isset($_POST['default'])){
        $peminjaman->getpeminjaman();    
    }
}

$mainTitle = 'Peminjaman';

if (!isset($_GET['update'])) {
    if (isset($_POST['tambah'])) {
        if ($peminjaman->addpeminjaman($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'peminjaman.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'peminjaman.php';
            </script>";
        }
    }
    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');



$formtambah = '<div class="col gx-2 gy-3 justify-content-center">
<form action="peminjaman.php" method="post" role="form" id="form-add">
    <input type="hidden" name="id" id="id">
    <div class="mb-3">
        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
    </div>
    <div class="mb-3">
        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
        <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
    </div>
    <div class="mb-3">
        <label for="kode_peminjaman" class="form-label">Kode Peminjaman</label>
        <input type="text" class="form-control" id="kode_peminjaman" name="kode_peminjaman" required>
    </div>
    

    <a href="peminjaman.php"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button></a>
    <button type="submit" class="btn btn-primary text-white" name="tambah" id="tambah" form="form-add">tambah</button>
</form>
</div>
';

$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Tanggal Peminjaman</th>
<th scope="row">Tanggal Pengembalian</th>
<th scope="row">Kode Peminjaman</th>
<th scope="row">Aksi</th>
</tr>';

$data = null;
$no = 1;
$formLabel = 'Peminjaman';

while ($div = $peminjaman->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['tanggal_pinjam'] . '</td>
    <td>' . $div['tanggal_kembali'] . '</td>
    <td>' . $div['kode_peminjaman'] . '</td>
    <td style="font-size: 22px;">
        <a href="peminjaman.php?update=' . $div['id_peminjaman'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="peminjaman.php?hapus=' . $div['id_peminjaman'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['update'])) {
    $id = $_GET['update'];
    if ($id > 0) {
        if (isset($_POST['update'])) {
            if ($peminjaman->updatepeminjaman($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'peminjaman.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'peminjaman.php';
            </script>";
            }
        }

        $peminjaman->getpeminjamanById($id);
        $row = $peminjaman->getResult();

        $formupdate = '<div class="col gx-2 gy-3 justify-content-center">
        <form action="" method="post" role="form" id="form-add">
            <input type="hidden" name="id_update" id="id_update">
            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal pinjam</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="'.$row['tanggal_pinjam'].'" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="'.$row['tanggal_kembali'].'" required>
            </div>
            <div class="mb-3">
                <label for="kode_peminjaman" class="form-label">Kode Peminjaman</label>
                <input type="text" class="form-control" id="kode_peminjaman" name="kode_peminjaman" value="'.$row['kode_peminjaman'].'" required>
            </div>
            

            <a href="peminjaman.php"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button></a>
            <button type="submit" class="btn btn-primary text-white" name="update" id="update" form="form-add">update</button>
        </form>
        </div>
        ';

        $dataUpdate = $row['kode_peminjaman'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($peminjaman->deletepeminjaman($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'peminjaman.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'peminjaman.php';
            </script>";
        }
    }
}

$peminjaman->close();

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
