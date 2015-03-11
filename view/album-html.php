<?php
$albumSet = isset($album);
if ($albumSet === false) {
    trigger_error('Oops: view/photos-html.php needs an Album object $album.');
}
// set title
$albumName = $album['name'];
$albumNameProper = StringFunctions::dashToSpace($albumName);
$albumNameProper =  ucwords($albumNameProper);
$pageData->setTitle("Album &middot; {$albumNameProper}");
// set body class
$albumNameQueryFormat = strtolower($albumName);
$albumNameQueryFormat = StringFunctions::formatAsQueryString($albumNameQueryFormat);
$pageData->setBodyClass("body-{$albumNameQueryFormat}");

// gallery css
$pageData->addCss('css/gallery.css');

// google fonts
$pageData->addCss('http://fonts.googleapis.com/css?family=Oswald');
// fancybox css
$pageData->addCss('res/fancybox/jquery.fancybox.css', "media='screen'");
// fancybox js
$pageData->addJs('res/fancybox/jquery.fancybox.pack.js');
// spin
$pageData->addJs('res/spin/jquery.spin.js');
// wookmark
$pageData->addJs('res/imagesloaded/imagesloaded.pkgd.min.js');
$pageData->addJs('res/wookmark/wookmark.js');
$pageData->addJs('js/wookmark-init.js');

// fancybox js code
$pageData->addScriptCode("
    $('.fancybox').fancybox({
        openEffect: 'fade',
        closeEffect: 'fade',
        prevEffect: 'fade',
        nextEffect: 'fade',
        helpers: {
            // keep from jumping to top of window
            // http://stackoverflow.com/questions/13547007/fancybox2-fancybox-causes-page-to-to-jump-to-the-top
            overlay: {
                locked: false
            }
        }
    });
");

$galleryHTML = "
<!--<div class='row'>
    <div class='small-12 columns'>-->
        <div class='progress-bar'></div>
        <div id='main' role='main' data-album-id='{$album['id']}'>
            <ul id='gallery-container' class='tiles-wrap animated'>
";
/*
    include_once 'model/table/ImagesTable.class.php';
    $imagesTable = new ImagesTable($db);
    $images = $imagesTable->getImagesWithAlbumId($album['id']);
    // for each image in the album...
    while ($image = $images->fetch(PDO::FETCH_ASSOC)) {
        $albumDir = StringFunctions::formatAsQueryString($album['name']);
        $imgLocation = "img/gallery/{$albumDir}/{$image['name']}";
        $imgDimensions = getimagesize($imgLocation)[3];
        
        $galleryHTML .= "
            <li><img src='{$imgLocation}' {$imgDimensions} alt='{$image['name']}'>
                <p>{$image['name']}</p>
            </li>
        ";
    }
*/
$galleryHTML .= "
            </ul>
        </div>
    <!--</div>
</div>-->
";

return $galleryHTML;
