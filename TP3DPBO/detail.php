<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Buku.php');
include('classes/Genre.php');
include('classes/Anggota.php');
include('classes/Peminjaman.php');
include('classes/Template.php');

$buku = new buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$buku->open();

$data = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $buku->getbukuById($id);
        $row = $buku->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail Buku ' . $row['judul_buku'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['foto_buku'] . '" class="img-thumbnail" alt="' . $row['foto_buku'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Penulis</td>
                                    <td>:</td>
                                    <td>' . $row['penulis_buku'] . '</td>
                                </tr>
                                <tr>
                                    <td>Tahun Terbit</td>
                                    <td>:</td>
                                    <td>' . $row['tahun_terbit_buku'] . '</td>
                                </tr>
                                <tr>
                                    <td>Status Buku</td>
                                    <td>:</td>
                                    <td>' . $row['status_buku'] . '</td>
                                </tr>
                                <tr>
                                    <td>Genre Buku</td>
                                    <td>:</td>
                                    <td>' . $row['nama_genre'] . '</td>
                                </tr>
                                <tr>
                                    <td>Tanggal terahir di pinjam</td>
                                    <td>:</td>
                                    <td>' . $row['tanggal_pinjam'] . '</td>
                                </tr>
                                <tr>
                                <td>Dipinjam oleh</td>
                                <td>:</td>
                                <td>' . $row['nama_anggota'] . '</td>
                            </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
            <a href="updatebuku.php?id_update=' . $id . '"><button type="button" class="btn btn-success text-white" id="update">Ubah Data</button></a>
            <a href="deletebuku.php?id_delete=' . $id . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </form>            
            </div>';
    }
}

$buku->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_PENGURUS', $data);
$detail->write();
