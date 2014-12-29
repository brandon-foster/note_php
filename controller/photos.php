<?php
$pageDataSet = isset($pageData);
if ($pageDataSet === false) {
    trigger_error('Oops: controller/photos.php needs a PageData object $pageData');
}

include_once 'model/PhotosData.class.php';
$photosData = new PhotosData();

// tie in the appropriate view, either the albums page 'view/photos-html.php',
// or the album page 'view/album-html.php'
$albumParamSet = isset($_GET['album']);
if ($albumParamSet) {
    $album = $photosData->getAlbumByName($_GET['album']);
    // redirect if no album found
    if ($album === NULL) {
        redirect404();
    }
    $output = include_once 'view/album-html.php';    
} else {
    $output = include_once 'view/photos-html.php';
}

// redirect if query string is such that no view was tied in
if (isset($output) === false) {
    redirect404();
}

return $output;
