<?php
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/login.css');

include_once 'model/table/UsersTable.class.php';
$usersTable = new UsersTable($db);

// set default page, if login fails or form not submitted
$page = 'signup-html';
if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // create user
    $signupResult = $usersTable->createUser($username, $password, $email);
    if ($signupResult === false) {
        $page = 'login-html';
    } else {
        $page = 'signup-success-html';
    }
    
}
$loginOut = include_once "view/admin/{$page}.php";
return $loginOut;
