<?php
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/login-signup.css');

include_once 'model/table/UsersTable.class.php';
$usersTable = new UsersTable($db);

// handle form submission
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // check if username exists
    if ($usersTable->usernameExists($username)) {
        // so far so good, validate login
        $checkLogin = $usersTable->validateLogin($username, $password);
    
        if ($checkLogin === true) {
            $checkLogin = 'SUCCESS, IT WORKED';
        } else {
            $checkLogin = 'OOPS, IT DIDN\'T WORK';
        }
//         if ($validLogin) {
//             redirect('admin.php?page=dashboard');
//         }
    }
    // username does not exists
    else {
        $loginMessage = "Username <em>{$username}</em> does not exist.";
    }
}

$loginOut = include_once 'view/admin/login-html.php';
return $loginOut;
