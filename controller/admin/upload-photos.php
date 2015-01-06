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
        if (file_exists($_FILES['user-image']['tmp_name'])) {
            
            // check if the user submitted a custom file name, to set $imageName
            if (!empty($_POST['user-image-name'])) {
                $userImageName = $_POST['user-image-name'];
                $imageName = $userImageName;
                $uploader = new Uploader('user-image', $userImageName);
            }
            // if the user did not submit a custom file name, use the name of 
            // the file he/she is uploading
            else {
                $imageName = $_FILES['user-image']['name'];
                $uploader = new Uploader('user-image');
            }
            
            $albumName = StringFunctions::formatAsQueryString($selectedAlbum);

            // attempt to store image in the file system
            $uploader->saveInDir("img/gallery/{$albumName}");
            try {
                $uploader->save();
                $uploadMessage = "<p class='failure-message'>Image <em><strong>{$imageName}</strong></em> successfully uploaded into album <em><strong>{$albumName}</strong></em></p>";
                
                // store image details in db
                include_once 'model/table/ImagesTable.class.php';
                $imagesTable = new ImagesTable($db);
                $imagesTable->addImage($imageName, $albumId);
            } catch (Exception $ex) {
                $uploadMessage = "<p class='failure-message'>{$ex->getMessage()}</p>";
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
