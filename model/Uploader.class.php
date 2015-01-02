<?php 
class Uploader {
    private $filename = "";
    private $fileData = "";
    private $destination = "";
    private $errorMessage = "";
    private $errorCode = "";

    public function __construct($key, $customName=NULL) {
        if (isset($customName)) {
            $this->filename = $customName;
        } else {
            $this->filename = $_FILES[$key]['name'];
        }
        $this->fileData = $_FILES[$key]['tmp_name'];
        $this->errorCode = ($_FILES[$key]['error']);
    }

    public function saveInDir($dir) {
        $this->destination = $dir;
    }

    // move file if ready, else throw exception
    public function save() {
        if ($this->readyToUpload()) {
            move_uploaded_file(
	          $this->fileData,
	          "{$this->destination}/" . basename($this->filename)
            );
        } else {
            $ex = new Exception($this->errorMessage);
            throw $ex;
        }
    }
    
    /*
     * Return true if image can be uploaded successfully,
     * else set $this->errorMessage and return false
     */
    public function readyToUpload() {
        $folderIsWritable = is_writable($this->destination);
        
        // folder not writable
        if ($folderIsWritable === false) {
            $this->errorMessage = "Error: destination folder is not writable, change permissions";
            $canUpload = false;
        }
        // file size too big
        else if ($this->errorCode === 1) {
            $maxSize = ini_get('upload_max_filesize');
            $this->errorMessage = "Error: File is too big. Max file size is {$maxSize}";
            $canUpload = false;
        } else if ($this->errorCode > 1) {
            $this->errorMessage = "Error: an error occured in attemping to upload the file. PHP file upload error {$this->errorCode}.";
            $canUpload = false;
        }
        
        // upload is fine
        else {
            $canUpload = true;
        }
        return $canUpload;
    }
}
