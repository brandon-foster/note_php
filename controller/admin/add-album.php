<?php
include_once 'model/table/AlbumsTable.class.php';
$albumsTable = new AlbumsTable($db);

// check if new album form was submitted
if (isset($_POST['add-album'])) {
    if (isset($_POST['album-name'])) {
        $newAlbumName = $_POST['album-name'];

        // check that album name does not already exist
        if (!$albumsTable->albumNameExists($newAlbumName)) {
            
            // check that directory for album does not exist (i.e., "New Album"'s directory would be "img/gallery/new-album"
            $dirFormatAlbumName = StringFunctions::formatAsQueryString($newAlbumName);
            if (!file_exists("img/gallery/$dirFormatAlbumName")) {
                // insert into albums table
                $albumsTable->addAlbum($newAlbumName);

                // create directory
                $oldMask = umask(0);
                mkdir("img/gallery/$dirFormatAlbumName", 0777, true);
                umask($oldMask);

                $uploadMessage = "<p class='failure-message'>New album <em><strong>$newAlbumName</strong></em> created.</p>";
            }
            else {
                $uploadMessage = "<p class='failure-message'>There already exists an album with the slug <em><strong>$dirFormatAlbumName</em></strong></p>";
            }
         }
        else {
            $uploadMessage = "<p class='failure-message'>Album name <em><strong>$newAlbumName</strong></em> already exists.</p>";
        }
    }
}

$addAlbumOut = include_once 'view/admin/add-album-html.php';
return $addAlbumOut;
