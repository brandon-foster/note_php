<?php
$pageDataSet = isset($pageData);
if ($pageDataSet === false) {
    trigger_error('Oops: controller/photos.php needs a PageData object $pageData');
}

include_once 'model/PhotosData.class.php';
$photosData = new PhotosData();

// set title
$pageData->setTitle('Photos');
// set body class
$pageData->setBodyClass('body-photos');
// google fonts
$pageData->addCss('http://fonts.googleapis.com/css?family=Oswald');
// fancybox css
$pageData->addCss('res/fancybox/jquery.fancybox.css', "media='screen'");
// add album timeline styles
// fancybox js
$pageData->addJs('res/fancybox/jquery.fancybox.pack.js');
// Ali Jafarian's js code
$pageData->addScriptCode("
$(document).ready(function() {
	$('.grid-nav li a').on('click', function(event){
		event.preventDefault();
		$('.grid-container').fadeOut(300, function(){
			$('#' + gridID).fadeIn(300);
		});
		var gridID = $(this).attr('data-id');
		
		$('.grid-nav li a').removeClass('active');
		$(this).addClass('active');
	});
});
");
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

$output = include_once 'view/photos-html.php';
return $output;
