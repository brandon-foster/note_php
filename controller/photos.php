<?php
// include_once 'model/PhotosData.class.php';
// $photosData = new PhotosData();

include_once 'model/table/AlbumsTable.class.php';
$albumsTable = new AlbumsTable($db);

// tie in the appropriate view, either the albums page 'view/photos-html.php',
// or the album page 'view/album-html.php'
$albumParamSet = isset($_GET['album']);
if ($albumParamSet) {
    $properAlbumName = $_GET['album'];
    $properAlbumName = StringFunctions::dashToSpace($properAlbumName);
    $album = $albumsTable->getAlbumByName($properAlbumName);
    // redirect if no album found
    if (empty($album)) {
        redirect404();
    }
    $output = include_once 'view/album-html.php';
} else {
    // provide view with $albums
    $albums = $albumsTable->getAlbums();

    $output = include_once 'view/photos-html.php';
}

return $output;
