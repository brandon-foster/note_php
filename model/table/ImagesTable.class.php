<?php
include_once 'model/table/Table.class.php';

class ImagesTable extends Table {
    public function addImage($name, $albumId, $caption=NULL, $location=NULL) {
        $sql = "
            INSERT INTO images
                (name, album_id, caption, location)
            VALUES (:name, :album_id, :caption, :location)";
        
        $params = array(
        	':name' => $name,
            ':album_id' => $albumId,
            ':caption' => $caption,
            ':location' => $location
        );

        $this->makeStatement($sql, $params);
    }
}
