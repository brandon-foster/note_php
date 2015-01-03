<?php
include_once 'model/table/PostCategoriesTable.class.php';
$postCategoriesTable = new PostCategoriesTable($db);

$categoriesOut = '';

// tie in the appropriate view, category page 'view/category-html.php', or the 
// post 'view/post-html.php'.
if (isset($_GET['category'])) {

    // opening tag for row
    $categoriesOut .= "<div class='row'>";

    // set the secondary navigation menu, with the current category highlighted
    // provide secondary-nav-html with $secondaryNavItems: all the nav items 
    // whose parent_id is the id of the "Categories" item
    function getSideNavItems($db) {
        include_once 'model/table/NavItemsTable.class.php';
        $navItemsTable = new NavItemsTable($db);
        $parentId = $navItemsTable->getIdByName('Categories');
        $sideNavItems = $navItemsTable->getNavChildrenOf($parentId);
        return $sideNavItems;
    }

    $sideNavItems = getSideNavItems($db);
    $sideNav = include_once 'view/component/side-nav-html.php';
    $categoriesOut .= $sideNav;

    // provide the category
    $categoryName = $_GET['category'];
    $categoryName = StringFunctions::dashToSpace($categoryName);
    $categoryName = ucwords($categoryName);
    $category = $postCategoriesTable->getCategoryByName($categoryName);
    // redirect if no category found
    if ($category === NULL || empty($category)) {
        redirect404();
    }

    // tie in the post page 'view/post-html.php'
    if (isset($_GET['title'])) {
        // provide post-html with the post
        include_once 'model/table/PostsTable.class.php';
        $postsTable = new PostsTable($db);
    
        $title = $_GET['title'];
        $title = StringFunctions::dashToSpace($title);
        $title = ucwords($title);
    
        $post = $postsTable->getPostByName($title);
        $categoriesOut .= include_once 'view/post-html.php';
    }
    // tie in the category page 'view/category-html.php' (which contains all the posts
    // of a particular category)
    else {
        // provide category-html with all the posts of the specified category
        include_once 'model/table/PostsTable.class.php';
        $postsTable = new PostsTable($db);
        $categoryId = $postCategoriesTable->getCategoryIdByName($categoryName);
        $categoryPosts = $postsTable->getPostsListingByCategoryId($categoryId);
        $categoriesOut .= include_once 'view/category-html.php';
    }
    
    // closing tag for row
    $categoriesOut .= "</div>";
}
// tie in the categories page 'view/categories-html.php',
// or the
else {
    $categoryItems = $postCategoriesTable->getCategories();
    $categoriesOut .= include_once 'view/categories-html.php';
}

return $categoriesOut;
