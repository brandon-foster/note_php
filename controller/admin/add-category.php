<?php
/*
 * Creates a new entry in post_categories table with specified category name. Creates a new entry in nav_items with the specified category name, and parent is the entry of name 'Categories', and href is index.php?page=categories&category={$categoryName} where $categoryName is the specified category being created.
 */

/*
 * Creates the nav_items entry
 */
function createCategoryNavEntry($categoryName, $db) {
    include_once 'model/table/NavItemsTable.class.php';
    $navItemsTable = new NavItemsTable ( $db );
    
    // check that the category name does not already exist in the nav_items table
    if (!$navItemsTable->navNameExists($categoryName)) {
        
        include_once 'model/table/PostCategoriesTable.class.php';
        $categoriesTable = new PostCategoriesTable($db);
        
        // check that the category name does not already exist in the post_categories table
        if (!$categoriesTable->categoryNameExists($categoryName)) {
            
            // create the category in the post_categories table
            $categoriesTable->addCategory($categoryName);
            
            // prepare for inserting nav item in nav_items table
            // parent_id
            $parentId = $navItemsTable->getIdByName('Categories');

            // href
            $queryStringFormatedName = StringFunctions::formatAsQueryString($categoryName);
            $href = "index.php?page=categories&category={$queryStringFormatedName}";

            // create the nav item in the nav_items table
            // name, parent_id, has_child, href, admin_only
            $navItemsTable->addNavItem($categoryName, $parentId, 0, $href, 0);

            $uploadMessage = "<p class='failure-message'>Category item <em><strong>$categoryName</strong></em> added.</p>";
            return $uploadMessage;
        }
        else {
            $uploadMessage = "<p class='failure-message'>Category item <em><strong>$categoryName</strong></em> already exists.</p>";
            return $uploadMessage;
        }
    } else {
        $uploadMessage = "<p class='failure-message'>Navigation item <em><strong>$categoryName</strong></em> already exists.</p>";
        return $uploadMessage;
    }
}

// check if new category form was submitted
if (isset ( $_POST ['add-category'] )) {
    if (! empty ( $_POST ['category-name'] )) {
        $newCategoryName = $_POST ['category-name'];
        $uploadMessage = createCategoryNavEntry($newCategoryName, $db);
    } else {
        $uploadMessage = "<p class='failure-message'>Please enter a name for the navigation item.</p>";
    }
}

$addNavOut = include_once 'view/admin/add-category-html.php';
return $addNavOut;
