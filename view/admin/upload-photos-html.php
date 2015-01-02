<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}
if (!isset($uploadMessage)) {
    $uploadMessage = '';
}
if (!isset($photosData)) {
    trigger_error('Oops: view/admin/upload-photos-html.php needs a PhotosData object $photosData');
}

// set title
$pageData->setTitle('Upload Photos');
// set body class
$pageData->setBodyClass('body-upload-photos');
// add css
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/pretty-form.css');
// javascript input focus code (added to $pageData before return'ed)
// focus on album-name by default
if (!isset($jsFocusCode)) {
    $jsFocusCode = '$("select[name=album-name]").focus();';
}
if (!isset($selected)) {
    $selected = '';
}

// set js focus script
$pageData->addScriptCode($jsFocusCode);

// get existing albums from PhotosData object
$albums = $photosData->getAlbums();
$albumOptionsHTML = '';
$numAlbums = count($albums);
for ($i = 0; $i < $numAlbums; $i++) {
    $currentAlbum = $albums[$i];
    $albumName = $currentAlbum->getName();
    if (!empty($selected) && $albumName == $selected) {
        $selected = "selected='selected'";
    } else {
        $selected = '';
    }
    $albumOptionsHTML .= "<option value='{$albumName}' {$selected}>{$albumName}</option>";
}

$out = "
<div class='row center'>
    <div class='signup-panel'>
        <p class='welcome'>Upload Photo</p>
        {$uploadMessage}
        <form action='admin.php?page=upload-photos' method='POST' enctype='multipart/form-data'>
            <div class='row collapse'>
                <div class='small-2 columns '>
                    <span class='prefix'><i class='fi-folder'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 columns '>
                    <select name='album-name'>
                        <option value=''>Select album</option>
                        {$albumOptionsHTML}
                    </select>
                </div>
            </div>
            <div class='row collapse'>
                <div class='small-2 columns '>
                    <span class='prefix'><i class='fi-pencil'></i></span>
                </div>
                <div class='small-10 columns '>
                    <input type='text' name='user-image-name' placeholder='image name' />
                </div>
            </div>
            <div class='row collapse'>
                <div class='small-12  columns'>
                    <input type='file' name='user-image' />
                </div>
            </div>
            <input type='submit' name='upload' value='Upload' class='button' />
        </form>
    </div>
</div>";

return $out;
