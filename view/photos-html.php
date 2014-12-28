<?php
$photosDataSet = isset($photosData);
if ($photosDataSet === false) {
    trigger_error('Oops: view/photos-html.php needs a PhotosData object $photosData.');
}

// set title
$pageData->setTitle('Photos');
// set body class
$pageData->setBodyClass('body-photos');

$photosOutput = "<pre>";
$photosOutput .= print_r($photosData->getAlbums(), true);
$photosOutput .= "</pre>";

// count number of albums
$albumsHTML = "";
$albums = $photosData->getAlbums();
$size = count($albums);
for ($i = 0; $i < $size; $i++) {
    $current = $albums[$i];
    
    // ensure that rows are of three columns each
    if ($i % 3 === 0) {
        $albumsHTML .= "<div class='row'>";
    }
    
    $albumsHTML .= "
    <div class='large-4 small-6 columns'>
        <a class='th' href='index.php?page=photos&album={$current->getName()}'><img alt='{$current->getName()}' src='{$current->getDirectory()}/{$current->getFileNames()[0]}'></a>
        <div class='panel'>
            <p>{$current->getName()} &middot; {$current->getSize()} photos</p>
        </div>
    </div>";
    
    // ensure that rows are of three columns each
    if ($i % 3 === 2) {
        $albumsHTML .= "</div>";
    }
}

$photosOutput .= "
<!-- thumbnails -->
{$albumsHTML}
";

return $photosOutput;
