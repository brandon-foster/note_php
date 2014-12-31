<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}

$user = $_SESSION['user'];
$dashboardOut = include_once 'view/admin/dashboard-html.php';
return $dashboardOut;