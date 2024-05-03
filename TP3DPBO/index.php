<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Buku.php');
include('classes/Genre.php');
include('classes/Anggota.php');
include('classes/Peminjaman.php');
include('classes/Template.php');

// buat instance buku
$listbuku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listbuku->open();
// tampilkan data buku
$listbuku->getBukuJoin();

// cari buku
if (isset($_POST['btn-cari'])) {
    // methode mencari data buku
    $listbuku->searchBuku($_POST['cari']);
}
else {
    if(isset($_POST['asc'])){
        $listbuku->bukuAsc();    
    }
    else if(isset($_POST['desc'])){
        $listbuku->bukuDesc();    
    }
    else if(isset($_POST['default'])){
        $listbuku->getBukuJoin();    
    }
}


$data = null;

// ambil data buku
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listbuku->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 buku-thumbnail">
        <a href="detail.php?id=' . $row['id_buku'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['foto_buku'] . '" class="card-img-top" alt="' . $row['foto_buku'] . '">
            </div>
            <div class="card-body">
                <p class="card-text buku-name my-0">' . $row['judul_buku'] . '</p>
                <p class="card-text penulis-name">' . $row['penulis_buku'] . '</p>
                <p class="card-text tahun-name my-0">' . $row['tahun_terbit_buku'] . '</p>
                <p class="card-text status-name my-0">Status: ' . $row['status_buku'] . '</p>
                <p class="card-text genre-name my-0">Genre: ' . $row['nama_genre'] . '</p>
                <p class="card-text pinjam-name my-0">Terakhir pinjam: ' . $row['tanggal_pinjam'] . '</p>
                <p class="card-text anggota-name my-0">Dipinjam Oleh: ' . $row['nama_anggota'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

// tutup koneksi
$listbuku->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_BUKU', $data);
$home->write();
