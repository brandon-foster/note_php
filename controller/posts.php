<?php
include_once 'model/table/PostCategoriesTable.class.php';
$postCategoriesTable = new PostCategoriesTable($db);

// tie in the appropriate view, either the categories page 'view/posts-html.php',
// or the category page 'view/category-html.php', which contains all the posts 
// of a particular category
$categoryParamSet = isset($_GET['category']);
if ($categoryParamSet) {
    $categoryName = $_GET['category'];
    $categoryName = StringFunctions::dashToSpace($categoryName);
    $categoryName = ucwords($categoryName);
    $category = $postCategoriesTable->getCategoryByName($categoryName);
    // redirect if no category found
    if ($category === NULL || empty($category)) {
        redirect404();
    }
    
    // provide category-html with all the posts of the specified category
    $categoryId = $postCategoriesTable->getCategoryIdByName($categoryName);

    include_once 'model/table/PostsTable.class.php';
    $postsTable = new PostsTable($db);
    $categoryPosts = $postsTable->getPostsListingByCategoryId($categoryId);
    $out = include_once 'view/category-html.php';
} else {
    $categoryItems = $postCategoriesTable->getCategories();
    $out = include_once 'view/posts-html.php';
}

return $out;
