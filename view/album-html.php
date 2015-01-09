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
$albumNameLower = strtolower($albumName);
$pageData->setBodyClass("body-{$albumNameLower}");
$pageData->addCss('css/gallery-style.css');
$pageData->addCss('css/gallery-main.css');
// google fonts
$pageData->addCss('http://fonts.googleapis.com/css?family=Oswald');
// fancybox css
$pageData->addCss('res/fancybox/jquery.fancybox.css', "media='screen'");
// fancybox js
$pageData->addJs('res/fancybox/jquery.fancybox.pack.js');
// imagesloaded
$pageData->addJs('js/jquery.imagesloaded.js');
// wookmark
$pageData->addJs('js/jquery.wookmark.js');
$pageData->addScriptCodeHead('
    addEventListener("load", function() {
        setTimeout(hideURLbar, 0);
    }, false);
        
    function hideURLbar() {
        window.scrollTo(0,1);
    }
');
// custom js
$pageData->addJs('js/album.js');

// fancybox js code
$pageData->addScriptCode("
    $('.fancybox').fancybox({
        openEffect: 'fade',
        closeEffect: 'fade',
        prevEffect: 'fade',
        nextEffect: 'fade'
    });
");

$galleryHTML = "
<!--<div class='row' id='loading-info-row'>
    <div class='small-12 columns'>
        <h4 id='loading-message'>loading...</h4>
        <div class='progress small-12 round'>
          <span id='loading-progress-meter' class='meter'></span>
        </div>
    </div>
</div>-->

<div class='content'>
    <div class='wrap'>
        <div id='main' role='main' data-album-id='{$album['id']}'>
            <ul id='tiles'>
";

// for each image in the album...
//    $albumDir = StringFunctions::formatAsQueryString($album['name']);
//    $imgLocation = "img/gallery/{$albumDir}/{$image['name']}";

//    $galleryHTML .= "
//                <li>
//                    <a href='{$imgLocation}' class='fancybox' data-fancybox-group='gallery' title='title here'>
//                        <img src='{$imgLocation}' width='282' height='118'>
//                    </a>
//                    <div class='post-info'>
//                        <div class='post-basic-info'>
//                            <h3><a href='#'>Animation films</a></h3>
//                            <span><a href='#'><label> </label>Movies</a></span>
//                            <p>Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
//                        </div>

//                    </div>
//                </li>";

$galleryHTML .= "
            </ul>
        </div>
    </div>
</div>
";

return $galleryHTML;
