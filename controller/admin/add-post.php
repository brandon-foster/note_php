<?php


// provide the view with categories
include_once 'model/table/CategoriesTable.class.php';
$categoriesTable = new CategoriesTable($db);
$categoriesItems = $categoriesTable->getCategories();

$out = include_once 'view/admin/add-post-html.php';
return $out;
