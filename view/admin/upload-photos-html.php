<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}
if (!isset($albumsTable)) {
    trigger_error('Oops: view/admin/upload-photos-html.php needs an AlbumsTable object $albumsTable');
}
if (!isset($uploadMessage)) {
    $uploadMessage = '';
}
if (!isset($selectedAlbum)) {
    $selectedAlbum = '';
}

// set title
$pageData->setTitle('Upload Photos');
// set body class
$pageData->setBodyClass('body-upload-photos');
// add css
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/pretty-form.css');
$pageData->addCss('res/uploadfilemulti/css/uploadfilemulti.css');
// javascript input focus code (added to $pageData before return'ed)
// focus on album-name by default
if (!isset($jsFocusCode)) {
    $jsFocusCode = '$("select[name=album-id]").focus();';
}
// add js
$pageData->addJs('/notes/res/uploadfilemulti/js/jquery.fileuploadmulti.min.js');
$pageData->addJs('/notes/js/multifileupload-init.js');

// set js focus script
$pageData->addScriptCode($jsFocusCode);

$albums = $albumsTable->getAlbums();
$albumOptionsHTML = '';

while ($album = $albums->fetch(PDO::FETCH_ASSOC)) {
    $albumName = $album['name'];
    if (!empty($selectedAlbum) && $albumName == $selectedAlbum) {
        $selected = "selected='selected'";
    } else {
        $selected = '';
    }
    
    $albumId = $album['id'];
    $albumOptionsHTML .= "<option value='{$albumId}' {$selected}>{$albumName}</option>";
}

$out = "
<div class='row center'>
    <div id='mulitplefileuploader'>Upload</div>
    <div id='status'></div>

    <div class='signup-panel'>
        <h2 class='welcome'>Upload Photo</h2>
        {$uploadMessage}
        <form>
            <div class='row collapse'>
                <div class='small-2 medium-1 columns '>
                    <span class='prefix'><i class='fi-folder'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 medium-11 columns '>
                    <select name='album-id'>
                        <option value=''>Select album</option>
                        {$albumOptionsHTML}
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>";

return $out;
