<?php

class Peminjaman extends DB
{
    function getpeminjaman(){
        $query = "SELECT * FROM peminjaman";
        return $this->execute($query);
    }

    function getpeminjamanById($id){
        $query = "SELECT * FROM peminjaman WHERE id_peminjaman=$id";
        return $this->execute($query);
    }

    function addpeminjaman($data){
        $tanggal_pinjam = $data['tanggal_pinjam'];
        $tanggal_kembali = $data['tanggal_kembali'];
        $kode_peminjaman = $data['kode_peminjaman'];

        $query = "INSERT INTO peminjaman VALUES('', '$tanggal_pinjam', '$tanggal_kembali', '$kode_peminjaman')";
        return $this->executeAffected($query);
    }

    function updatepeminjaman($id, $data){
        $tanggal_pinjam = $data['tanggal_pinjam'];
        $tanggal_kembali = $data['tanggal_kembali'];
        $kode_peminjaman = $data['kode_peminjaman'];
    
        $query = "UPDATE peminjaman SET tanggal_pinjam='$tanggal_pinjam', tanggal_kembali='$tanggal_kembali', kode_peminjaman='$kode_peminjaman' WHERE id_peminjaman=$id";
        return $this->executeAffected($query);
    }
    
    function deletepeminjaman($id){
        $query = "DELETE FROM peminjaman WHERE id_peminjaman=$id";
        return $this->executeAffected($query);
    }

    function searchpeminjaman($keyword){
        $query = "SELECT * FROM peminjaman WHERE kode_peminjaman LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function peminjamanAsc(){
        $query = "SELECT * FROM peminjaman ORDER BY tanggal_pinjam ASC";
        return $this->execute($query);
    }

    function peminjamanDesc(){
        $query = "SELECT * FROM peminjaman ORDER BY tanggal_pinjam DESC";
        return $this->execute($query);
    }  
}