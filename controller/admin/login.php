<?php
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/login-signup.css');

include_once 'model/table/UsersTable.class.php';
$usersTable = new UsersTable($db);

// set default page, if login fails or form not submitted
$page = 'login-html';

// handle form submission
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // get user from table
    $usernameExists = $usersTable->usernameExists($username);    
    if ($usernameExists) {
        $page = 'dashboard-html';
    }    
}

$loginOut = include_once "view/admin/{$page}.php";
return $loginOut;
