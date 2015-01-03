<?php
include_once 'model/table/PostCategoriesTable.class.php';
$postCategoriesTable = new PostCategoriesTable($db);


// provide view with $categoryItems
$categoryItems = $postCategoriesTable->getCategories();
$out = include_once 'view/posts-html.php';
return $out;
