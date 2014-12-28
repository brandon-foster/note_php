<?php
$pageDataSet = isset($pageData);
if ($pageDataSet === false) {
    trigger_error('Oops: controller/default.php needs a PageData object $pageData');
}

// set title
$pageData->setTitle('Home');
// set body class
$pageData->setBodyClass('');

$pageData->addRowHead(); // begin row
// small only side links
$smallSideLinks = include_once 'view/component/side-links-html-small.php';
$pageData->addContent($smallSideLinks);
// main content
$homeMainContent = include_once 'view/component/home-main-html.php';
$pageData->addContent($homeMainContent);
// medium and up side links
$medSideLinks = include_once 'view/component/side-links-html-med.php';
$pageData->addContent($medSideLinks);
$pageData->addRowTail(); // end row

return;