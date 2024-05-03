<?php

class Genre extends DB
{
    function getgenre()
    {
        $query = "SELECT * FROM genre";
        return $this->execute($query);
    }

    function getgenreById($id)
    {
        $query = "SELECT * FROM genre WHERE id_genre=$id";
        return $this->execute($query);
    }

    function addgenre($data)
    {
        $nama_genre = $data['nama_genre'];
        $query = "INSERT INTO genre VALUES('', '$nama_genre')";
        return $this->executeAffected($query);
    }

    function updategenre($id, $data)
    {
        $nama_genre = $data['nama_genre'];
        $query = "UPDATE genre SET nama_genre='$nama_genre' WHERE id_genre=$id";
        return $this->executeAffected($query);
    }

    function deletegenre($id)
    {
        $query = "DELETE FROM genre WHERE id_genre=$id";
        return $this->executeAffected($query);
    }

    function searchgenre($keyword){
        $query = "SELECT * FROM genre WHERE nama_genre LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function genreAsc(){
        $query = "SELECT * FROM genre ORDER BY nama_genre ASC";
        return $this->execute($query);
    }

    function genreDesc(){
        $query = "SELECT * FROM genre ORDER BY nama_genre DESC";
        return $this->execute($query);
    }  
}