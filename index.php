<?php
include_once 'model/PageData.class.php';

// PageData object: it's members are used in the template
// view/page-template-html.php, which is 'include'ed from this file
$pageData = new PageData();

// FOUNDATION AND CUSTOM CSS
$pageData->addCss('css/main.css');
$pageData->addCss('res/foundation/css/normalize.css');
$pageData->addCss('res/foundation/css/foundation.css');

// FOUNDATION JS
$pageData->addJs('res/foundation/js/vendor/jquery.js');
$pageData->addJs('res/foundation/js/vendor/fastclick.js');
$pageData->addJs('res/foundation/js/foundation.min.js');
$pageData->addScriptCode('$(document).foundation();');
$pageData->addJs('js/nav.js');

// NAVIGATION
$nav = include_once 'view/component/nav-html.php';
$pageData->setNav($nav);

// CONTENT
$controller = 'default';
$pageRequested = isset($_GET['page']);
if ($pageRequested) {
    // select the appropriate controller
    $controller = $_GET['page'];
    
    // do not load controller unless they are in the list of valid controllers,
    // to prevent against requests like index.php?page=controller-does-not-exist
    if ($controller !== 'photos') {
        header('Location: 404.php');
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
