<?php

class Anggota extends DB
{
    function getanggota(){
        $query = "SELECT * FROM anggota";
        return $this->execute($query);
    }

    function getanggotaById($id){
        $query = "SELECT * FROM anggota WHERE id_anggota=$id";
        return $this->execute($query);
    }

    function addanggota($data){
        $nama_anggota = $data['nama_anggota'];
        $alamat_anggota = $data['alamat_anggota'];
        $no_telpon_anggota = $data['no_telpon_anggota'];
        $email_anggota = $data['email_anggota'];

        $query = "INSERT INTO anggota VALUES('', '$nama_anggota', '$alamat_anggota', '$no_telpon_anggota', '$email_anggota')";
        return $this->executeAffected($query);
    }

    function updateanggota($id, $data){
        $nama_anggota = $data['nama_anggota'];
        $alamat_anggota = $data['alamat_anggota'];
        $no_telpon_anggota = $data['no_telpon_anggota'];
        $email_anggota = $data['email_anggota'];
    
        $query = "UPDATE anggota SET nama_anggota='$nama_anggota', alamat_anggota='$alamat_anggota', no_telpon_anggota='$no_telpon_anggota', email_anggota='$email_anggota' WHERE id_anggota=$id";
        return $this->executeAffected($query);
    }
    
    function deleteanggota($id){
        $query = "DELETE FROM anggota WHERE id_anggota=$id";
        return $this->executeAffected($query);
    }

    function searchanggota($keyword){
        $query = "SELECT * FROM anggota WHERE nama_anggota LIKE '%$keyword%'";
        return $this->execute($query);
    }
    
    function anggotaAsc(){
        $query = "SELECT * FROM anggota ORDER BY nama_anggota ASC";
        return $this->execute($query);
    }

    function anggotaDesc(){
        $query = "SELECT * FROM anggota ORDER BY nama_anggota DESC";
        return $this->execute($query);
    }  

}