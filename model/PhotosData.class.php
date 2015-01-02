<?php
include_once 'model/Album.class.php';

class PhotosData {
    const ALBUMS_DIR = 'img/gallery'; 

    private $albums = array();
    
    /*
     * Populate the $albums field upon construction
     */
    public function __construct() {
        $this->createAlbums();
    }
    
    /*
     * Returns an array of Album objects
     */
    public function getAlbums() {        
        return $this->albums;
    }
    
    /*
     * Return the album object with the name $name
     */
    public function getAlbumByName($name) {
        foreach ($this->albums as $album) {
            if ($album->getName() === $name) {
                return $album;
            }
        }
        // album not found
    }
    
    /*
     * Populate $this->albums
     */
    private function createAlbums() {
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
        
            $name = $albumNames[$i];
            $album = new Album($directory, $name, count($albumFiles));
            array_push($this->albums, $album);
        }
    }
}