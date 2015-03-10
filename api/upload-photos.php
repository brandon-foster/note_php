<?php

/*
 * Return an array of associative arrays representing images
 */

function makeErrorJson($errorMessage) {
    $errorArray = array(
    	'error' => $errorMessage
    );
    $errorJson = json_encode($errorArray);
    return $errorJson;
}

/*
 * Send a json response
 */
function sendJsonReponse($responseJson) {
    header("Content-Type: application/json");
    echo $responseJson;
}

// check if album-id query param is set
if (isset($_GET['album-id']) && strlen($_GET['album-id']) !== 0) {
    $albumId = $_GET['album-id'];
    
    // check if new image was submitted
    if (isset($_FILES['user-image'])) {        
    
        // include models
        //include_once 'model/Uploader.class.php';
        include_once 'model/table/AlbumsTable.class.php';
        $albumsTable = new AlbumsTable($db);
        
        $selectedAlbum = $albumsTable->getAlbumNameById($albumId);            
        
        // check that the user selected an image to upload
        $numImages = count($_FILES['user-image']['name']);
        
        $albumName = StringFunctions::formatAsQueryString($selectedAlbum);
        $output_dir = 'img/gallery/' . $albumName;
        if(!is_array($_FILES['user-image']['name'])) //single file
        {
            $RandomNum   = time();

            $ImageName = str_replace(' ','-',strtolower($_FILES['user-image']['name']));
            $ImageType = $_FILES['user-image']['type']; //"image/png", image/jpeg etc.

            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt = str_replace('.','',$ImageExt);
            $ImageName = preg_replace('/\.[^.\s]{3,4}$/', '', $ImageName);
            $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

            // store image on disk
            move_uploaded_file($_FILES['user-image']['tmp_name'], $output_dir . '/' . $NewImageName);

            // include model
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
            $imagesTable->addImage($NewImageName, $albumId, NULL, NULL, $albumCover);

            // increment count in appropriate album
            $albumsTable->incrementCountById($albumId);
        }
        else {
            $fileCount = count($_FILES['user-image']['name']);
            for($i=0; $i < $fileCount; $i++)
            {
                $RandomNum   = time();
            
                $ImageName = str_replace(' ','-',strtolower($_FILES['user-image']['name'][$i]));
                $ImageType = $_FILES['user-image']['type'][$i]; //"image/png", image/jpeg etc.
            
                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt = str_replace('.','',$ImageExt);
                $ImageName = preg_replace('/\.[^.\s]{3,4}$/', '', $ImageName);
                $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
    
                move_uploaded_file($_FILES['user-image']['tmp_name'][$i], $output_dir . '/' . $NewImageName);

                // include model
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
                $imagesTable->addImage($NewImageName, $albumId, NULL, NULL, $albumCover);
                
                // increment count in appropriate album
                $albumsTable->incrementCountById($albumId);
            }
        }

        /*if (file_exists($_FILES['user-image']['tmp_name'][0])) {

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
            $errorMessageJson = makeErrorJson($uploadMessage);
            sendJsonReponse($errorMessageJson);
            
            //$jsFocusCode = '$("input[name=user-image]").focus();';
        }*/
    }
}

// album-id query param not set
else {
    $uploadMessage = "<p class='failure-message'>album-id query parameter not set. Please select an album to upload into.</p>";
    $errorMessageJson = makeErrorJson($uploadMessage);
    sendJsonReponse($errorMessageJson);
}
