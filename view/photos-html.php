<?php
if (!isset($albums)) {
    trigger_error('Oops: view/photos-html.php needs an object $albums.');
}

// set title
$pageData->setTitle('Photos');
// set body class
$pageData->setBodyClass('body-photos');

$albumsHTML = "<!-- thumbnails -->";

// check if empty
if ($albums->rowCount() == 0) {
    $albumsHTML .= "
        <div class='row'>
            <div class='small-12 columns'>
                <h3>No albums</h3>
            </div>
        </div>";
}
else {
    $i = 0;
    while ($album = $albums->fetch(PDO::FETCH_ASSOC)) {
        // ensure that rows are of three columns each
        if ($i % 3 === 0) {
            $albumsHTML .= "<div class='row'>";
        }
    
        // if empty album
        if ($album['count'] === '0') {
            $albumsHTML .= "
            <div class='large-4 small-6 columns'>
                <a class='th' href='index.php?page=photos&album={$album['name']}'><img alt='{$album['name']}' src='http://placehold.it/295x221'></a>
                <div class='panel'>
                <p>{$album['name']} &middot; {$album['count']} photos</p>
                </div>
            </div>";
        }
        // if nonempty album
        else {
            // directory for the album
                $dirFormatName = StringFunctions::formatAsQueryString($album['name']);
        
                // image name for album cover
                include_once 'model/table/ImagesTable.class.php';
            $imagesTable = new ImagesTable($db);
            $imageCoverName = $imagesTable->getAlbumCoverNameByAlbumId($album['id']);
    
            // build the album cover src
            $src = "img/gallery/{$dirFormatName}/{$imageCoverName}";
    
            $albumsHTML .= "
                <div class='large-4 small-6 columns'>
                    <a class='th' href='index.php?page=photos&album={$dirFormatName}'><img alt='{$album['name']}' src='{$src}'></a>
                    <div cclass='panel'>
                    <p>{$album['name']} &middot; {$album['count']} photos</p>
                    </div>
                </div>";
        }
        
        // ensure that rows are of three columns each
        // if $i == 2 (every third album
        // or if $i < 2 and it's the last album (therefore $i is either 0 or 1)
        if ($i % 3 === 2 || ($i < 2 && $i == $albums->rowCount() - 1)) {
            $albumsHTML .= "</div>";
        }
        $i++;
    }
    
}

return $albumsHTML;
