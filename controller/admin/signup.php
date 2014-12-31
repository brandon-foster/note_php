<?php
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/login-signup.css');

include_once 'model/table/UsersTable.class.php';
$usersTable = new UsersTable($db);

$signupOut = include_once "view/admin/signup-html.php";
return $signupOut;
