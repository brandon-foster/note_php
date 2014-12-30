<?php
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/login-signup.css');

include_once 'model/table/UsersTable.class.php';
$usersTable = new UsersTable($db);

// set default page, if login fails or form not submitted
$page = 'signup-html';
// $signupOut = include_once 'controller/admin/signup-router.php';
$signupOut = include_once "view/admin/{$page}.php";
return $signupOut;
