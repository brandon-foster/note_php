<?php
function redirect404() {
    header('Location: 404.php');
}
include_once 'util/StringFunctions.php';

// PDO for db interactions
include_once 'db.php';

// start or resume session
session_start();

// PageData object: it's members are used in the template
// view/page-template-html.php, which is 'include'ed from this file
include_once 'model/PageData.class.php';
$pageData = new PageData();

// FOUNDATION AND CUSTOM CSS
$pageData->addCss('css/main.css');
$pageData->addCss('res/foundation-5.5.0/css/normalize.css');
$pageData->addCss('res/foundation-5.5.0/css/foundation.css');

// FOUNDATION JS
$pageData->addJs('res/foundation-5.5.0/js/vendor/jquery.js');
$pageData->addJs('res/foundation-5.5.0/js/vendor/fastclick.js');
$pageData->addJs('res/foundation-5.5.0/js/foundation.min.js');
$pageData->addScriptCode('$(document).foundation();');

// NAVIGATION
$nav = include_once 'controller/nav.php';
$pageData->setNav($nav);

// CONTENT
$controller = 'default';
$pageRequested = isset($_GET['page']);
if ($pageRequested) {
    // select the appropriate controller
    $controller = $_GET['page'];
    
    // do not load controller unless they are in the list of valid controllers,
    // to prevent against requests like index.php?page=controller-does-not-exist
    if ($controller !== 'photos'
        && $controller !== 'posts') {
        redirect404();
    }
}

$content = include "controller/{$controller}.php";
$pageData->addContent($content);

// FOOTER
$footer = include_once 'view/component/footer-html.php';
$pageData->setFooter($footer);

// load and echo the template
$page = include_once 'view/page-template-html.php';
echo $page;
