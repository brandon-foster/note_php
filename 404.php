<?php
// start or resume session
session_start();

include_once 'util/StringFunctions.php';

include_once 'model/PageData.class.php';
$pageData = new PageData();
$pageData->setTitle('Page not found');

// FOUNDATION AND CUSTOM CSS
$pageData->addCss('css/main.css');
$pageData->addCss('res/foundation/css/normalize.css');
$pageData->addCss('res/foundation/css/foundation.css');

// FOUNDATION JS
$pageData->addJs('res/foundation/js/vendor/jquery.js');
$pageData->addJs('res/foundation/js/vendor/fastclick.js');
$pageData->addJs('res/foundation/js/foundation.min.js');
$pageData->addScriptCode('$(document).foundation();');

// NAVIGATION
// PDO for db interactions
include_once 'db.php';
$nav = include_once 'controller/nav.php';
$pageData->setNav($nav);

$content = "
<div class='row'>
    <div class='small-12 columns'>
        <h2>Oops</h2>
        <p>It seems that the page you're looking for cannot be found</p>
    </div>
</div>";
$pageData->addContent($content);


$page = include_once 'view/page-template-html.php';
echo $page;?>
