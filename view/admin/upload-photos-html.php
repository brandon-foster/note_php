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
// javascript input focus code (added to $pageData before return'ed)
// focus on album-name by default
if (!isset($jsFocusCode)) {
    $jsFocusCode = '$("select[name=album-id]").focus();';
}

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
// $numAlbums = count($albums);
// for ($i = 0; $i < $numAlbums; $i++) {
//     $currentAlbum = $albums[$i];
//     $albumName = $currentAlbum->getName();
//     if (!empty($selected) && $albumName == $selected) {
//         $selected = "selected='selected'";
//     } else {
//         $selected = '';
//     }
//     $albumOptionsHTML .= "<option value='{$albumName}' {$selected}>{$albumName}</option>";
// }

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
                    <select name='album-id'>
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
