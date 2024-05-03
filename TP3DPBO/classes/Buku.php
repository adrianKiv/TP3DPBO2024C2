<?php

class Buku extends DB
{
    function getbuku(){
        $query = "SELECT * FROM buku";
        return $this->execute($query);
    }

    function getBukuJoin(){
        $query = "SELECT * FROM buku 
        JOIN genre ON buku.id_genre=genre.id_genre 
        JOIN peminjaman ON buku.id_peminjaman=peminjaman.id_peminjaman 
        JOIN anggota ON buku.id_anggota=anggota.id_anggota 
        ORDER BY buku.id_buku";
        return $this->execute($query);
    }

    function getbukuById($id){
        $query = "SELECT * FROM buku 
        JOIN genre ON buku.id_genre=genre.id_genre 
        JOIN peminjaman ON buku.id_peminjaman=peminjaman.id_peminjaman
        JOIN anggota ON buku.id_anggota=anggota.id_anggota 
        WHERE id_buku=$id";
        return $this->execute($query);
    }

    function addbuku($data){
        $judul_buku = $data['judul_buku'];
        $penulis_buku = $data['penulis_buku'];
        $tahun_terbit_buku = $data['tahun_terbit_buku'];
        $status_buku = $data['status_buku'];
        $genre = $data['genre'];
        $peminjaman = $data['peminjaman'];
        $anggota = $data['anggota'];

        $foto_buku = $_FILES['foto_buku']['name'];
        $foto_temp = $_FILES['foto_buku']['tmp_name'];
        $foto_path = 'assets/images/' . $foto_buku;
        move_uploaded_file($foto_temp, $foto_path);

        $query = "INSERT INTO buku VALUES('', '$judul_buku', '$penulis_buku', '$tahun_terbit_buku', '$status_buku', '$genre', '$foto_buku', '$peminjaman', '$anggota')";
        return $this->executeAffected($query);
    }

    function updatebuku($id, $data, $file){
        // Dapatkan data dari array $data
        $judul_buku = $data['judul_buku'];
        $penulis_buku = $data['penulis_buku'];
        $tahun_terbit_buku = $data['tahun_terbit_buku'];
        $status_buku = $data['status_buku'];
        $genre = $data['id_genre'];
        $peminjaman = $data['id_peminjaman'];
        $anggota = $data['id_anggota'];
        
        // Dapatkan nama file foto lama dari array $data
        $foto_lama = $data['foto_lama'];
        
        // Dapatkan nama file foto baru dari array $file
        $foto_buku = $file['foto_buku']['name'];
        $foto_temp = $file['foto_buku']['tmp_name'];
        $foto_path = 'assets/images/'. $foto_buku;
        
        // Cek apakah pengguna memasukkan foto baru
        if ($foto_buku!= '') {
            // Jika ada foto baru, hapus foto lama
            if (file_exists($foto_lama)) {
                unlink($foto_lama);
            }
            
            // Jika ada foto baru, pindahkan file foto ke direktori yang ditentukan
            move_uploaded_file($foto_temp, $foto_path);
        } else {
            // Jika tidak ada foto baru, gunakan foto lama
            $foto_buku = $foto_lama; // Pastikan 'foto_lama' ada dalam array $data
        }
        
        // Buat query untuk update data buku
        $query = "UPDATE buku SET judul_buku = '$judul_buku', penulis_buku = '$penulis_buku', tahun_terbit_buku = '$tahun_terbit_buku', status_buku = '$status_buku', id_genre = '$genre', foto_buku = '$foto_buku', id_peminjaman = '$peminjaman', id_anggota = '$anggota' WHERE id_buku = '$id'";
        
        // Jalankan query dan kembalikan jumlah baris yang terpengaruh
        return $this->executeAffected($query);
    }
    
    
    function deletebuku($id){
        $query = "DELETE FROM buku WHERE id_buku=$id";
        return $this->executeAffected($query);
    }

    function searchBuku($keyword){
        $query = "SELECT * FROM buku 
        JOIN genre ON buku.id_genre=genre.id_genre 
        JOIN peminjaman ON buku.id_peminjaman=peminjaman.id_peminjaman 
        JOIN anggota ON buku.id_anggota=anggota.id_anggota 
        WHERE judul_buku LIKE '%$keyword%'";
        return $this->execute($query);
    }

    // Fungsi untuk mengambil data buku dengan mengurutkan secara ascending berdasarkan nama buku
    function bukuAsc(){
        $query = "SELECT * FROM buku 
        JOIN genre ON buku.id_genre=genre.id_genre 
        JOIN peminjaman ON buku.id_peminjaman=peminjaman.id_peminjaman 
        JOIN anggota ON buku.id_anggota=anggota.id_anggota 
        ORDER BY judul_buku ASC";
        return $this->execute($query);
    }
    // Fungsi untuk mengambil data buku dengan mengurutkan secara descending berdasarkan nama buku
    function bukuDesc(){
        $query = "SELECT * FROM buku 
        JOIN genre ON buku.id_genre=genre.id_genre 
        JOIN peminjaman ON buku.id_peminjaman=peminjaman.id_peminjaman 
        JOIN anggota ON buku.id_anggota=anggota.id_anggota 
        ORDER BY judul_buku DESC";
        return $this->execute($query);
    }  
}