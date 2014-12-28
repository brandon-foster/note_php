<?php
class Album {
    private $directory = "";
    private $name = "";
    private $size = 0; // number of images in the album
    private $fileNames = array();

    public function __construct($directory, $name, $size) {
        $this->directory = $directory;
        $this->name = $name;
        $this->size = $size;
        $this->fileNames = $this->setFilesArray();
    }

    private function setFilesArray() {
        $nameList = array();

        $handle = opendir($_SERVER['DOCUMENT_ROOT'] . '/' . $this->directory);

        // store file names
        while (false !== ($entry = readdir($handle))) {
            if ($entry != '.' && $entry != '..') {
                array_push($nameList, $entry);
            }
        }

        return $nameList;
    }

    public function getDirectory() {
        return $this->directory;
    }

    public function getName() {
        return $this->name;
    }

    public function getSize() {
        return $this->size;
    }

    public function getFileNames() {
        return $this->fileNames;
    }
}
