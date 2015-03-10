<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}
include_once 'model/Uploader.class.php';

// provide view with AlbumsTable object
include_once 'model/table/AlbumsTable.class.php';
$albumsTable = new AlbumsTable($db);

// check if new image form was submitted
if (isset($_POST['upload'])) {

    // check that album id was submitted
    if (isset($_POST['album-id']) && strlen($_POST['album-id']) !== 0) {
        $albumId = $_POST['album-id'];
        $selectedAlbum = $albumsTable->getAlbumNameById($albumId);
        
        // check that the user selected an image to upload
        $numImages = count($_FILES['user-image']['name']);
        if (file_exists($_FILES['user-image']['tmp_name'][0])) {     

            for ($i = 0; $i < $numImages; $i++) {
                // attempt to store image in the file system
                $filename = $_FILES['user-image']['name'][$i];
                $fileData = $_FILES['user-image']['tmp_name'][$i];
                $errorCode = $_FILES['user-image']['error'][$i];
                
                $uploader = new Uploader($filename, $fileData, $errorCode);
                $albumName = StringFunctions::formatAsQueryString($selectedAlbum);
                $uploader->saveInDir("img/gallery/{$albumName}");
                
                try {
                    $uploader->save();
                
                    // store image details in db
                    include_once 'model/table/ImagesTable.class.php';
                    $imagesTable = new ImagesTable($db);
                
                    // set as album cover if user requested
                    if (isset($_POST['album-cover'])) {
                        // get id of current album cover
                        $currentAlbumCoverId = $imagesTable->getAlbumCoverIdByAlbumId($albumId);
                        // unset the album_cover status for the image that is the current album cover
                        $imagesTable->setAlbumCoverValue($currentAlbumCoverId, 0);
                
                        $albumCover = 1;
                    }
                    // set as album cover if album is empty
                    else if ($albumsTable->getCountById($albumId) === '0') {
                        $albumCover = 1;
                    }
                    else {
                        $albumCover = 0;
                    }
                
                    // store image in db
                    $imageName = $filename;
                    $imagesTable->addImage($imageName, $albumId, NULL, NULL, $albumCover);
                
                    // increment count in appropriate album
                    $albumsTable->incrementCountById($albumId);
                    
                    $imageOrImages = StringFunctions::singularOrPlural('Image', $numImages);
                    $uploadMessage = "<p class='failure-message'>{$imageOrImages} successfully uploaded into album <em><strong>{$albumName}</strong></em></p>";
                } catch (Exception $ex) {
                    $uploadMessage = "<p class='failure-message'>{$ex->getMessage()}</p>";
                }
            }
        }
        else {
            $uploadMessage = "<p class='failure-message'>Please select an image to upload.</p>";
            $jsFocusCode = '$("input[name=user-image]").focus();';
        }
    }
    else {
            $uploadMessage = "<p class='failure-message'>Please select an album to upload into.</p>";
    }
}

// $deleteImage = isset($_GET['delete-image']);
// if ($deleteImage) {
//     $whichImage = $_GET['delete-image'];

//     // php function to delete a file
//     if (file_exists($whichImage)) {
//         unlink($whichImage);
//     }
// }

$out = include_once 'view/admin/upload-photos-html.php';
return $out;
