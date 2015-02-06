<?php

include_once 'model/table/PostsTable.class.php';
$postsTable = new PostsTable($db);

include_once 'model/table/PostCategoriesTable.class.php';
$postCategoriesTable = new PostCategoriesTable($db);

// handle edit submission
if (isset($_POST['edit-post'])) {
    $postId = $_POST['id'];
    $title = $_POST['title'];
    $categoryId = $_POST['category-id'];  
    $text = $_POST['text'];
    $dateCreated = $_POST['date-created'];

    if ($postsTable->editPostById($postId, $title, $categoryId, $text, $dateCreated)) {
        $editPostMessage = "<p class='failure-message'>Post successfully updated.</p>";
    }
}

// check if specific quotation is being edited or if a list of all quotations should be listed
if (isset($_GET['id'])) {
    // provide view with $postRow
    $postId = $_GET['id'];
    $postRow = $postsTable->getPostById($postId);
    
    // provide view with $categoryItems
    $categoryItems = $postCategoriesTable->getCategories();

    // provide view with the category name of the post categoryId
    $categoryId = $postsTable->getCategoryIdByPostId($postId);
    //$selected = $postCategoriesTable->getCategoryNameById($categoryId);

    $out = include_once 'view/admin/edit-post-html.php';
    return $out;
}
// list all quotations to have user choose one for editing
else {
    // get all quotations    
    // provide view with $postRows
    $postRows = $postsTable->getPostsListing();
    $out = include_once 'view/admin/list-posts-html.php';
    return $out;
}
