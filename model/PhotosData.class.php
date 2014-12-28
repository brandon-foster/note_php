<?php
include_once 'model/Album.class.php';

class PhotosData {
    const ALBUMS_DIR = 'img/gallery'; 

    private $albums = array();

    /*
     * Returns an array of Album objects
     */
    public function getAlbums() {        
        $albumNames = array();
        
        $handle = opendir(self::ALBUMS_DIR);
        
        // store album names
        while (false !== ($entry = readdir($handle))) {
            if ($entry != '.' && $entry != '..') {
                array_push($albumNames, $entry);
            }
        }
        
        // create each Album object and store it in $this->albums
        $size = count($albumNames);
        for ($i = 0; $i < $size; $i ++) {
            $directory = self::ALBUMS_DIR . '/' . $albumNames[$i];
            $albumFiles = scandir($directory);
            
            $album = new Album($directory, $albumNames[$i], count($albumFiles));
            array_push($this->albums, $album);
        }
        
        return $this->albums;
    }
}