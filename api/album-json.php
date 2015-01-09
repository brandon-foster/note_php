<?php

/*
 * Return an array of associative arrays representing images
 */
function makeImagesArray($albumId, $imagesTable) {
    $imagesArray = array();
    
    // id, name, album_id, caption, location, album_cover, date
    $index = 0;
    $images = $imagesTable->getImagesWithAlbumId($albumId);
    while ($image = $images->fetch(PDO::FETCH_ASSOC)) {
        // alter date value
        $image['date'] = date('F j, Y', strtotime($image['date']));
        
        $imagesArray[$index] = $image;
        $index++;
    }
    
    return $imagesArray;
}

function makeAlbumJson($albumId, $albumsTable, $imagesTable) {
    $imagesArray = makeImagesArray($albumId, $imagesTable);

    $album = $albumsTable->getAlbumById($albumId);

    $responseArray = array(
            'id' => $album['id'],
            'name' => $album['name'],
            'directory' => StringFunctions::formatAsQueryString($album['name']),
            'count' => $album['count'],
            'date' => date('F j, Y',  strtotime($album['date'])),
            'images' => $imagesArray
    );

    // return response
    $responseJson = json_encode($responseArray);
    return $responseJson;
}

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

// get a list of all the images in the album
if (isset($_GET['album-id'])) {

    /*
     * Format:
     * 
     * {
     *      "id" : 0,
     *      "name" : "Blacksburg Summer"
     *      "directory" : "blacksburg-summer",
     *      "images" : {
     *                      0 : {
     *                          "id" : 3,
     *                          "name" : "IMG_2083.JPG",
     *                          "caption" : "Burrus Hall"
     *                          "location" : "Blacksburg, VA"
     *                          "album_cover" : "0",
     *                          "date" : "2015-01-06 23:19:22"
     *                      },
     *                      1 : {
     *                          "id" : 4,
     *                          "name" : "IMG_2084.JPG",
     *                          "caption" : "Burrus Hall"
     *                          "location" : "Blacksburg, VA"
     *                          "album_cover" : "0",
     *                          "date" : "2015-01-06 23:19:22"
     *                      },
     *                      2 : {
     *                          "id" : 91,
     *                          "name" : "IMG_2121.JPG",
     *                          "album_id" : 0
     *                          "caption" : "Burrus Hall"
     *                          "location" : "Blacksburg, VA"
     *                          "album_cover" : "0",
     *                          "date" : "2015-01-06 23:19:22"
     *                      }
     *      }
     * }
     */
    $albumId = $_GET['album-id'];
    
    include_once 'model/table/AlbumsTable.class.php';
    $albumsTable = new AlbumsTable($db);
    
    include_once 'model/table/ImagesTable.class.php';
    $imagesTable = new ImagesTable($db);

    // check if album exists
    $name = $albumsTable->getAlbumNameById($albumId);
    if ($name !== NULL) {
        $albumJson = makeAlbumJson($albumId, $albumsTable, $imagesTable);
        sendJsonReponse($albumJson);
    }
    
    // album does not exist
    else {
        $errorMessageJson = makeErrorJson("album does not exist");
        sendJsonReponse($errorMessageJson);
    }

}

// album-id query param not set
else {
    $errorMessageJson = makeErrorJson("album-id query parameter not set");
    sendJsonReponse($errorMessageJson);
}
