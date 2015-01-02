<?php
include_once 'model/Uploader.class.php';

// check if form was submitted
if (isset($_POST['upload'])) {

    // check that album name was submitted
    if (isset($_POST['album-name']) && strlen($_POST['album-name']) !== 0) {
        $selected = $_POST['album-name'];
        
        // check that the user selected an image to upload
        if (file_exists($_FILES['user-image']['tmp_name'])) {
            
            // check if the user submitted a custom file name, to set $imageName
            if (!empty($_POST['user-image-name'])) {
                $userImageName = $_POST['user-image-name'];
//                 $userImageName = 'cat.png';
                $imageName = $userImageName;
                $uploader = new Uploader('user-image', $userImageName);
            } else {
                $imageName = $_FILES['user-image']['name'];
                $uploader = new Uploader('user-image');
            }
            
            $albumName = $_POST['album-name'];
            $uploader->saveInDir("img/gallery/{$albumName}");
            
            try {
                $uploader->save();
                $uploadMessage = "<p class='failure-message'>Image <em><strong>{$imageName}</strong></em> successfully uploaded into album <em><strong>{$albumName}</strong></em></p>";
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

// create PhotosData object for upload-photos-html.php to use
include_once 'model/PhotosData.class.php';
$photosData = new PhotosData();

$out = include_once 'view/admin/upload-photos-html.php';
return $out;
