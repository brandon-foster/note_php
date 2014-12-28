<?php
$photosDataSet = isset($photosData);
if ($photosDataSet === false) {
    trigger_error('Oops: view/photos-html.php needs a PhotosData object $photosData.');
}

// $photosOutput = "<pre>";
// $photosOutput .= print_r($photosData->getAlbums(), true);
// $photosOutput .= "</pre>";

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

$photosOutput = "
<!-- thumnails -->
{$albumsHTML}
";

return $photosOutput;

// $photosOutput = "
// <!-- inspired by http://alijafarian.com/responsive-image-grids-using-css/  -->
// <div class='wrapper'>
//     <div class='container'>
//         <ul class='grid-nav'>
//             <li><a href='#' data-id='day-five' class='active'>Day 5</a></li>
//             <li><a href='#' data-id='day-four'>Day 4</a></li>
//             <li><a href='#' data-id='day-three'>Day 3</a></li>
//             <li><a href='#' data-id='day-two'>Day 2</a></li>
//             <li><a href='#' data-id='day-one'>Day 1</a></li>
//         </ul>

//         <!--  #day-five -->
//         <div id='day-five' class='grid-container'
//             style='display: block;'>
//             <ul class='rig columns-3'>
//                 <li><a href='/img/gallery/pri_001.jpg' class='fancybox' data-fancybox-group='day-five' title='image 1 title'><img src='/img/gallery/pri_001.jpg' /></a>
//                     <h3>DAY 5 Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//                 <li><a href='/img/gallery/pri_002.jpg' class='fancybox' data-fancybox-group='day-five' title='image 2 title'><img src='/img/gallery/pri_002.jpg' /></a>
//                     <h3>Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//                 <li><a href='/img/gallery/pri_003.jpg' class='fancybox' data-fancybox-group='day-five' title='image 3 title'><img src='/img/gallery/pri_003.jpg' /></a>
//                     <h3>Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//             </ul>
//         </div>
//         <!-- /#day-five -->

//         <!-- #day-four -->
//         <div id='day-four' class='grid-container'>
//             <ul class='rig columns-3'>
//                 <li><a href='/img/gallery/pri_004.jpg' class='fancybox' data-fancybox-group='day-four' title='image 4 title'><img src='/img/gallery/pri_004.jpg' /></a>
//                     <h3>DAY FOUR Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//                 <li><a href='/img/gallery/pri_005.jpg' class='fancybox' data-fancybox-group='day-four' title='image 5 title'><img src='/img/gallery/pri_005.jpg' /></a>
//                     <h3>Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//                 <li><a href='/img/gallery/pri_006.jpg' class='fancybox' data-fancybox-group='day-four' title='image 6 title'><img src='/img/gallery/pri_006.jpg' /></a>
//                     <h3>Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//             </ul>
//         </div>
//         <!-- /#day-four -->

//         <!-- #day-three -->
//         <div id='day-three' class='grid-container'>
//             <ul class='rig columns-3'>
//                 <li><img src='/img/gallery/pri_007.jpg' />
//                     <h3>DAY THREE Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//                 <li><img src='/img/gallery/pri_008.jpg' />
//                     <h3>Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//                 <li><img src='/img/gallery/pri_009.jpg' />
//                     <h3>Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//             </ul>
//         </div>
//         <!-- /#day-three -->

//         <!-- #day-two -->
//         <div id='day-two' class='grid-container'>
//             <ul class='rig columns-3'>
//                 <li><img src='/img/gallery/pri_010.jpg' />
//                     <h3>DAY TWO Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//                 <li><img src='/img/gallery/pri_011.jpg' />
//                     <h3>Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//                 <li><img src='/img/gallery/pri_012.jpg' />
//                     <h3>Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//             </ul>
//         </div>
//         <!-- /#day-two -->

//         <!-- #day-one -->
//         <div id='day-one' class='grid-container'>
//             <ul class='rig columns-3'>
//                 <li><img src='/img/gallery/pri_010.jpg' />
//                     <h3>DAY ONE Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//                 <li><img src='/img/gallery/pri_001.jpg' />
//                     <h3>Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//                 <li><img src='/img/gallery/pri_003.jpg' />
//                     <h3>Image Title</h3>
//                     <p>Lorem ipsum dolor sit amet, consectetur
//                         adipisicing elit, sed do eiusmod tempor
//                         incididunt ut labore et dolore magna aliqua.</p>
//                 </li>
//             </ul>
//         </div>
//         <!-- /#day-one -->

//         <p class='faded-footer-text'>
//             Image grid styles proudly found elsewhere. I encourage
//             you to check out Ali Jafarian's insightful <a
//                 href='http://alijafarian.com/responsive-image-grids-using-css/' target='_blank'>tutorial</a>
//             on responsive image grids.
//         </p>
        
//         <p class='faded-footer-text'>
//             <a href='http://fancyapps.com/fancybox/' target='_blank'>fancyBox</a> lightbox plugin provided by <a href='http://fancyapps.com/' target='_blank'>fancyApps</a>.
//         </p>
//     </div>
//     <!--/.container-->
// </div>
// <!--/.wrapper-->
// ";

// return $photosOutput;
