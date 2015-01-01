<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}
// set title
$pageData->setTitle('Upload Photos');
// set body class
$pageData->setBodyClass('body-upload-photos');
return "
<div class='row'>
    <h1>Upload Photos</h1>
</div>";