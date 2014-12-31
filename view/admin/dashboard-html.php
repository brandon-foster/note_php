<?php
$userSet = isset($user);
if ($user === false) {
    trigger_error('Oops: view/admin/dashboard-html.php needs $user.');
}

// set title
$pageData->setTitle('dashboard');
// set body class
$pageData->setBodyClass('body-dashboard');

$out = "<div class='row'>";
$out .= "<h1>Dashboard</h1>";

$out .= "<pre>";
$out .= print_r($user, true);
$out .= "</pre>";
$out .= "</div>";

return $out;