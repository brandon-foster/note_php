<?php
// handle already logged in user
if (isset($_SESSION['user'])) {
    // send to dashboard
    redirect('admin.php?page=dashboard');
}

$loginOut = include_once 'view/admin/login-html.php';
return $loginOut;
