<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}

// provide view with AlbumsTable object
include_once 'model/table/AlbumsTable.class.php';
$albumsTable = new AlbumsTable($db);

// $deleteImage = isset($_GET['delete-image']);
// if ($deleteImage) {
//     $whichImage = $_GET['delete-image'];

//     // php function to delete a file
//     if (file_exists($whichImage)) {
//         unlink($whichImage);
//     }
// }

$out = include_once 'view/admin/upload-photos-html.php';
return $out;
