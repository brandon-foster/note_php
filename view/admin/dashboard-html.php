<?php
$userResultSet = isset($userResult);
if ($userResultSet === false) {
    trigger_error('Oops: view/admin/dashboard-html.php needs $userResult.');
}
$pageData->setTitle('Dashboard');

$out = "<h1>Dashboard</h1>";

if ($userResult === false) {
    $out .= 'No user found.';
} 
if ($userResult === true) {
    $out .= 'User found';
}

$out .= "<pre>";
$out .= print_r($userResult, true);
$out .= "</pre>";

return $out;