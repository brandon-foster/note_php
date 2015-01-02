<?php
$userSet = isset($user);
if ($user === false) {
    trigger_error('Oops: view/admin/dashboard-html.php needs $user.');
}

// set title
$pageData->setTitle('Dashboard');
// set body class
$pageData->setBodyClass('body-dashboard');
return "
<div class='row'>
    <h1>Dashboard</h1>
</div>";
