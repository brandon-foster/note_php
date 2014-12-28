<?php
$photosDataSet = isset($photosData);
if ($photosDataSet === false) {
    trigger_error('Oops: view/photos-html.php needs a PhotosData object $photosData.');
}
$albumSet = isset($album);
if ($albumSet === false) {
    trigger_error('Oops: view/photos-html.php needs an Album object $album.');
}
$albumName = $album->getName();
// set title
$albumNameProper =  ucwords($albumName);
$albumNameLower = strtolower($albumName);
$pageData->setTitle("Album &middot; {$albumNameProper}");
// set body class
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
    
//     $galleryHTML .= "
//     <li>
//         <div>
//             <a href='{$location}' class='fancybox' data-fancybox-group='gallery' title='title here: {$name}'>
//                 <img src='{$location}' alt='{$name}' />
//             </a>
//             <h3>{$name}</h3>
//             <p>caption here</p>  
//         </div>
          
//     </li>";
}

$galleryHTML .= "
            </ul>
        </div>
    </div>
</div>
";

return $galleryHTML;

// <div class="content">
// <div class="wrap">
// <div id="main" role="main" style="height: 3033px;">
// <ul id="tiles">
// <!-- These are our grid blocks -->
// <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 0px; left: 18px;">
//         <img src="images/img1.jpg" width="282" height="118">
//                 <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 0px; left: 318px;">
//                         <img src="images/img2.jpg" width="282" height="344">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 0px; left: 618px;">
//                         <img src="images/img3.jpg" width="282" height="210">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 0px; left: 918px;">
//                         <img src="images/img4.jpg" width="282" height="385">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <!----//--->
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 355px; left: 18px;">
//                         <img src="images/img4.jpg" width="282" height="385">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 447px; left: 618px;">
//                         <img src="images/img3.jpg" width="282" height="210">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 581px; left: 318px;">
//                         <img src="images/img2.jpg" width="282" height="344">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 622px; left: 918px;">
//                         <img src="images/img1.jpg" width="282" height="118">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <!----//--->
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 894px; left: 618px;">
//                         <img src="images/img1.jpg" width="282" height="118">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 977px; left: 18px;">
//                         <img src="images/img2.jpg" width="282" height="344">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 977px; left: 918px;">
//                         <img src="images/img3.jpg" width="282" height="210">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 1162px; left: 318px;">
//                         <img src="images/img4.jpg" width="282" height="385">
//                         <div class="post-info">
//                         <div class="post-basic-info">
//                         <h3><a href="#">Animation films</a></h3>
//                         <span><a href="#"><label> </label>Movies</a></span>
//                         <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                         </div>
//                         <div class="post-info-rate-share">
//                         <div class="rateit">
//                         <span> </span>
//                         </div>
//                         <div class="post-share">
//                         <span> </span>
//                         </div>
//                         <div class="clear"> </div>
//                         </div>
//                         </div>
//                         </li>
//                         <!-- End of grid blocks -->
//                         <li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 1249px; left: 618px;">
//                         <img src="images/img1.jpg" width="282" height="118">
//                                 <div class="post-info">
//                                 <div class="post-basic-info">
//                                 <h3><a href="#">Animation films</a></h3>
//                                 <span><a href="#"><label> </label>Movies</a></span>
//                                 <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
//                                 </div>
//                                 <div class="post-info-rate-share">
//                                 <div class="rateit">
//                                 <span> </span>
//                                 </div>
//                                 <div class="post-share">
// 			        				<span> </span>
// 			        			</div>
// 			        			<div class="clear"> </div>
// 			        				        </div>
// 			        				                </div>
// 			        				                </li><li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 1424px; left: 918px;">
// 			        				                <img src="images/img2.jpg" width="282" height="344">
// 			        				                <div class="post-info">
// 			        				                <div class="post-basic-info">
// 			        				                <h3><a href="#">Animation films</a></h3>
// 			        				                <span><a href="#"><label> </label>Movies</a></span>
// 			        				                <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
// 			        				                </div>
// 			        				                <div class="post-info-rate-share">
// 			        			<div class="rateit">
// 			        				                        <span> </span>
// 			        				                        </div>
// 			        				                        <div class="post-share">
// 			        				                        <span> </span>
// 			        				                        </div>
// 			        				                        <div class="clear"> </div>
// 			        				                        </div>
// 			        				                        </div>
// 			        				                        </li><li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 1558px; left: 18px;">
// 			        				                                <img src="images/img3.jpg" width="282" height="210">
// 			        				                                <div class="post-info">
// 			        				                                <div class="post-basic-info">
// 			        				                                <h3><a href="#">Animation films</a></h3>
// 				        		<span><a href="#"><label> </label>Movies</a></span>
// 				        		<p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
// 				        		</div>
// 				        		<div class="post-info-rate-share">
// 				        		        <div class="rateit">
// 				        		        <span> </span>
// 				        		        </div>
// 				        		        <div class="post-share">
// 				        		        <span> </span>
// 				        		        </div>
// 				        		        <div class="clear"> </div>
// 				        		        </div>
// 				        		        </div>
// 				        		        </li><li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 1604px; left: 618px;">
// 				        		                <img src="images/img4.jpg" width="282" height="385">
// 			        	<div class="post-info">
// 			        	<div class="post-basic-info">
// 				        		<h3><a href="#">Animation films</a></h3>
// 				        		        <span><a href="#"><label> </label>Movies</a></span>
// 				        		        <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
// 				        		        </div>
// 				        		        <div class="post-info-rate-share">
// 				        		        <div class="rateit">
// 				        		        <span> </span>
// 				        		        </div>
// 				        		        <div class="post-share">
// 				        		        <span> </span>
// 				        		                </div>
// 				        		                <div class="clear"> </div>
// 				        		                </div>
// 				        		                </div>
// 				        		                </li><li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 1784px; left: 318px;">
// 			        	<img src="images/img4.jpg" width="282" height="385">
// 			        	<div class="post-info">
// 			        	        <div class="post-basic-info">
// 			        	                <h3><a href="#">Animation films</a></h3>
// 			        	                <span><a href="#"><label> </label>Movies</a></span>
// 			        	                <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
// 			        	                </div>
// 			        	                <div class="post-info-rate-share">
// 			        	                <div class="rateit">
// 			        	                <span> </span>
// 			        	                </div>
// 			        	                <div class="post-share">
// 			        	                <span> </span>
// 			        	                </div>
// 			        	                <div class="clear"> </div>
// 			        	                </div>
// 			        	</div>
// 			        </li><li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 2005px; left: 18px;">
// 			        <img src="images/img3.jpg" width="282" height="210">
// 			        <div class="post-info">
// 			        <div class="post-basic-info">
// 			        <h3><a href="#">Animation films</a></h3>
// 			        <span><a href="#"><label> </label>Movies</a></span>
// 			        <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
// 			        </div>
// 			        <div class="post-info-rate-share">
// 			                <div class="rateit">
// 			                <span> </span>
// 			                </div>
// 			                <div class="post-share">
// 			                <span> </span>
// 			        			</div>
// 			                        <div class="clear"> </div>
// 			        		</div>
// 			                                </div>
// 			                                        </li><li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 2005px; left: 918px;">
// 			                                        <img src="images/img2.jpg" width="282" height="344">
// 			                                        <div class="post-info">
// 			                                        <div class="post-basic-info">
// 			                                        <h3><a href="#">Animation films</a></h3>
// 			                                        <span><a href="#"><label> </label>Movies</a></span>
// 			                                        <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
// 			        		</div>
// 			                                                <div class="post-info-rate-share">
// 			                                                <div class="rateit">
// 			                                                <span> </span>
// 			                                                        </div>
// 			                                                        <div class="post-share">
// 			                                                        <span> </span>
// 			                                                        </div>
// 			                                                        <div class="clear"> </div>
// 			                                                                </div>
// 			                                                                </div>
// 			                                                                </li><li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 2226px; left: 618px;">
// 			                                                                <img src="images/img1.jpg" width="282" height="118">
// 			                                                                <div class="post-info">
// 			                                                                <div class="post-basic-info">
// 			                                                                <h3><a href="#">Animation films</a></h3>
// 			                                                                <span><a href="#"><label> </label>Movies</a></span>
// 			                                                                <p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
// 			                                                                </div>
// 			                                                                <div class="post-info-rate-share">
// 			                                                                <div class="rateit">
// 			        				<span> </span>
// 			        			</div>
// 			        			<div class="post-share">
// 			        				<span> </span>
// 			        			</div>
// 			        			<div class="clear"> </div>
// 			        		</div>
// 			        	</div>
// 			        </li><li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 2406px; left: 318px;">
// 			        	<img src="images/img1.jpg" width="282" height="118">
// 			        	<div class="post-info">
// 			        		<div class="post-basic-info">
// 				        		<h3><a href="#">Animation films</a></h3>
// 				        		<span><a href="#"><label> </label>Movies</a></span>
// 				        		<p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
// 			        		</div>
// 			        		<div class="post-info-rate-share">
// 			        			<div class="rateit">
// 			        				<span> </span>
// 			        			</div>
// 			        			<div class="post-share">
// 			        				<span> </span>
// 			        			</div>
// 			        			<div class="clear"> </div>
// 			        		</div>
// 			        	</div>
// 			        </li><li onclick="location.href='single-page.html';" style="display: list-item; position: absolute; top: 2452px; left: 18px;">
// 			        	<img src="images/img2.jpg" width="282" height="344">
// 						<div class="post-info">
// 			        		<div class="post-basic-info">
// 				        		<h3><a href="#">Animation films</a></h3>
// 				        		<span><a href="#"><label> </label>Movies</a></span>
// 				        		<p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry.</p>
// 			        		</div>
// 			        		<div class="post-info-rate-share">
// 			        			<div class="rateit">
// 			        				<span> </span>
// 			        			</div>
// 			        			<div class="post-share">
// 			        				<span> </span>
// 			        			</div>
// 			        			<div class="clear"> </div>
// 			        		</div>
// 			        	</div>
// 					</li></ul>
// 			    </div>
// 			</div>
// 		</div>
