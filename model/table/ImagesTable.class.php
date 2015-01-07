<?php
include_once 'model/table/Table.class.php';

class ImagesTable extends Table {
    public function getImagesWithAlbumId($albumId) {
        $sql = "
            SELECT id, name, album_id, caption, location, album_cover, date
            FROM images
            WHERE album_id = :album_id";
        
        $params = array(
        	':album_id' => $albumId
        );
        
        $result = $this->makeStatement($sql, $params);
        return $result;
    }
    
    public function setAlbumCoverValue($id, $value) {
        $sql = "
            UPDATE images
            SET album_cover = :value
            WHERE id = :id";
        
        $params = array(
        	':id' => $id,
            ':value' => $value
        );
        
        $this->makeStatement($sql, $params);
    }
    
    public function getAlbumCoverIdByAlbumId($albumId) {
        $sql = "
            SELECT id
            FROM images
            WHERE album_id = :album_id
                AND album_cover = 1";
        
        $params = array(
        	':album_id' => $albumId
        );
        
        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }
    
    public function getAlbumCoverNameByAlbumId($albumId) {
        $sql = "
            SELECT name
            FROM images
            WHERE album_id = :album_id
                AND album_cover = 1";
        
        $params = array(
        	':album_id' => $albumId
        );
        
        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['name'];
    }
    
    public function addImage($name, $albumId, $caption, $location, $albumCover=0) {
        $sql = "
            INSERT INTO images
                (name, album_id, caption, location, album_cover)
            VALUES (:name, :album_id, :caption, :location, :album_cover)";
        
        $params = array(
        	':name' => $name,
            ':album_id' => $albumId,
            ':caption' => $caption,
            ':location' => $location,
            ':album_cover' => $albumCover
        );

        $this->makeStatement($sql, $params);
    }
}
