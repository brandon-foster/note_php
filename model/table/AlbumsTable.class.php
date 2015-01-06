<?php
include_once 'model/table/Table.class.php';

class AlbumsTable extends Table {
    public function getAlbums() {
        $sql = "
            SELECT id, name, count, date
            FROM albums";
        
        $result = $this->makeStatement($sql);
        return $result;
    }
    
    public function getAlbumNameById($id) {
        $sql = "
            SELECT name
            FROM albums
            WHERE id = :id";
        
        $params = array(
        	':id' => $id
        );
        
        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $name = $row['name'];
        return $name;
    }
    
    public function addAlbum($albumName) {
        $sql = "
            INSERT INTO albums
                (name, count)
            VALUES
                (:name, :count)";
        
        $params = array(
        	':name' => $albumName,
            ':count' => 0
        );
        
        $this->makeStatement($sql, $params);
    }
    
    public function albumNameExists($name) {
        $sql = "
            SELECT 1
            FROM albums
            WHERE name = :name";
        
        $params = array(
                ':name' => $name
        );

        $result = $this->makeStatement($sql, $params);
        if ($result->rowCount() != 0) {
            return true;
        } else {
            return false;
        }
    }
}