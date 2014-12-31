<?php
// handle already logged in user
if (isset($_SESSION['user'])) {
    redirect('admin.php?page=dashboard');
}

include_once 'model/table/UsersTable.class.php';
$usersTable = new UsersTable($db);

$signupOut = include_once "view/admin/signup-html.php";
return $signupOut;
