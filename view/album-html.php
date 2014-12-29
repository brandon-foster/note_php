<?php
$albumSet = isset($album);
if ($albumSet === false) {
    trigger_error('Oops: view/photos-html.php needs an Album object $album.');
}
// set title
$albumName = $album->getName();
$albumNameProper = StringFunctions::dashToSpace($albumName);
$albumNameProper =  ucwords($albumNameProper);
$pageData->setTitle("Album &middot; {$albumNameProper}");
// set body class
$albumNameLower = strtolower($albumName);
$pageData->setBodyClass("body-{$albumNameLower}");
// google fonts
$pageData->addCss('css/gallery-style.css');
$pageData->addCss('css/gallery-main.css');
$pageData->addCss('http://fonts.googleapis.com/css?family=Oswald');
// fancybox css
$pageData->addCss('res/fancybox/jquery.fancybox.css', "media='screen'");
// fancybox js
$pageData->addJs('res/fancybox/jquery.fancybox.pack.js');
$pageData->addJs('js/jquery.imagesloaded.js');
$pageData->addJs('js/jquery.wookmark.js');
$pageData->addScriptCodeHead('
    addEventListener("load", function() {
        setTimeout(hideURLbar, 0);
    }, false);
        
    function hideURLbar() {
        window.scrollTo(0,1);
    }
');
$pageData->addScriptCode('
    (function ($){
      var $tiles = $("#tiles"),
          $handler = $("li", $tiles),
          $main = $("#main"),
          $window = $(window),
          $document = $(document),
          options = {
            autoResize: true, // This will auto-update the layout when the browser window is resized.
            container: $main, // Optional, used for some extra CSS styling
            offset: 20, // Optional, the distance between grid items
            itemWidth:280 // Optional, the width of a grid item
          };
      /**
       * Reinitializes the wookmark handler after all images have loaded
       */
      function applyLayout() {
        $tiles.imagesLoaded(function() {
          // Destroy the old handler
          if ($handler.wookmarkInstance) {
            $handler.wookmarkInstance.clear();
          }

          // Create a new layout handler.
          $handler = $("li", $tiles);
          $handler.wookmark(options);
        });
      }
      /**
       * When scrolled all the way to the bottom, add more tiles
       */
      function onScroll() {
        // Check if we"re within 100 pixels of the bottom edge of the broser window.
        var winHeight = window.innerHeight ? window.innerHeight : $window.height(), // iphone fix
            closeToBottom = ($window.scrollTop() + winHeight > $document.height() - 100);

        if (closeToBottom) {
          // Get the first then items from the grid, clone them, and add them to the bottom of the grid
          var $items = $("li", $tiles),
              $firstTen = $items.slice(0, 10);
          $tiles.append($firstTen.clone());

          applyLayout();
        }
      };

      // Call the layout function for the first time
      applyLayout();

      // Capture scroll event.
      //$window.bind("scroll.wookmark", onScroll);
    })(jQuery);
');

// fancybox js code
$pageData->addScriptCode("
    $(document).ready(function() {
        $('.fancybox').fancybox({
            openEffect: 'fade',
            closeEffect: 'fade',
            prevEffect: 'fade',
            nextEffect: 'fade'
        });
    });
");

$galleryHTML = "
<div class='content'>
    <div class='wrap'>
        <div id='main' role='main'>
            <ul id='tiles'>
";

$photoNames = $album->getFileNames();
foreach ($photoNames as $name) {
    $location = "{$album->getDirectory()}/{$name}";
    $galleryHTML .= "
    <li>
        <a href='{$location}' class='fancybox' data-fancybox-group='gallery' title='title here'>
            <img src='{$location}' width='282' height='118'>
        </a>
        <div class='post-info'>
            <div class='post-basic-info'>
                <h3><a href='#'>Animation films</a></h3>
                <span><a href='#'><label> </label>Movies</a></span>
                <p>Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
            </div>

        </div>
    </li>";
}

$galleryHTML .= "
            </ul>
        </div>
    </div>
</div>
";

return $galleryHTML;
