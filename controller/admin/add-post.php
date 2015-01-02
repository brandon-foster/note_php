<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}
include_once 'model/table/PostCategoriesTable.class.php';
$postCategoriesTable = new PostCategoriesTable($db);

include_once 'model/table/PostsTable.class.php';
$postsTable = new PostsTable($db);

// handle the submission
if (isset($_POST['add-post'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $text = $_POST['text'];
    
    // get the id of the category
    $categoryId = $postCategoriesTable->getCategoryIdByName($category);
    // insert the post
    $postsTable->addPost($title, $categoryId, $text);
    // increment the count of the category
    $postCategoriesTable->incrementCount($categoryId);

    $addPostMessage = "<p class='failure-message'>New post <em><strong>{$title}</strong></em> successfully added.</p>";
}

$categoriesItems = $postCategoriesTable->getCategories();
$out = include_once 'view/admin/add-post-html.php';
return $out;
