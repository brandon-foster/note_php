<?php
/*
 * Creates a new entry in post_categories table with specified category name. Creates a new entry in nav_items with the specified category name, and parent is the entry of name 'Categories', and href is index.php?page=categories&category={$categoryName} where $categoryName is the specified category being created.
 */
include_once 'model/table/NavItemsTable.class.php';
$navItemsTable = new NavItemsTable ( $db );

/*
 * Creates the nav_items entry
 */
function createCategoryNavEntry($categoryName) {
    // check that nav name does not already exist
    if (! $navItemsTable->navNameExists ( $categoryName )) {
        
        // for sticky form
        $selectedNavParent = $navItemsTable->getNameById ( $navParentId );
        
        if (isset ( $_POST ['admin-only'] )) {
            $adminOnly = $_POST ['admin-only'];
            
            if (isset ( $_POST ['has-child'] )) {
                $hasChild = $_POST ['has-child'];
                
                $queryStringFormatNavName = StringFunctions::formatAsQueryString ( $newNavName );
                
                // if the new navigation item is admin-only, then
                if ($adminOnly == 0) {
                    $href = "index.php?page={$queryStringFormatNavName}";
                } else if ($adminOnly == 1) {
                    $href = "admin.php?page={$queryStringFormatNavName}";
                }
                
                // check if user specified a URL
                if (! empty ( $_POST ['nav-url'] )) {
                    $href = $_POST ['nav-url'];
                }
                
                $navItemsTable->addNavItem ( $newNavName, $navParentId, $hasChild, $href, $adminOnly );
                
                $uploadMessage = "<p class='failure-message'>New navigation item <em>
                <strong>{$newNavName}</strong></em> created.</p>";
            } else {
                $uploadMessage = "<p class='failure-message'>Please indicate if the navigation item has children.</p>";
            }
        } else {
            $uploadMessage = "<p class='failure-message'>Please indicate if the navigation item is to be admin only.</p>";
        }

    } else {
        $uploadMessage = "<p class='failure-message'>Navigation item <em><strong>$newAlbumName</strong></em> already exists.</p>";
    }
}

// check if new category form was submitted
if (isset ( $_POST ['add-category'] )) {
    if (! empty ( $_POST ['category-name'] )) {
        $newCategoryName = $_POST ['category-name'];
        createCategoryNavEntry($newCategoryName);
    } else {
        $uploadMessage = "<p class='failure-message'>Please enter a name for the navigation item.</p>";
    }
}

$addNavOut = include_once 'view/admin/add-category-html.php';
return $addNavOut;
