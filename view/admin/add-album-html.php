<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}
if (!isset($uploadMessage)) {
    $uploadMessage = '';
}


// set title
$pageData->setTitle('Add Album');
// set body class
$pageData->setBodyClass('body-add-album');
// add css
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/pretty-form.css');
// javascript input focus code (added to $pageData before return'ed)
// focus on album-name by default
if (!isset($jsFocusCode)) {
    $jsFocusCode = '$("input[name=album-name]").focus();';
}
// set js focus script
$pageData->addScriptCode($jsFocusCode);

$out = "
<div class='row center'>
    <div class='signup-panel'>
        <p class='welcome'>Add Album</p>
        {$uploadMessage}
        <form action='admin.php?page=add-album' method='POST'>
            <div class='row collapse'>
                <div class='small-2 columns '>
                    <span class='prefix'><i class='fi-folder'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 columns '>
                    <input type='text' name='album-name' placeholder='new album name' />
                </div>
            </div>
            <input type='submit' name='add-album' value='Add Album' class='button' />
        </form>
    </div>
</div>";
return $out;
