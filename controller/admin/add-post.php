<?php
// handle not logged in user
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}
include_once 'model/table/PostCategoriesTable.class.php';
$postCategoriesTable = new PostCategoriesTable($db);

include_once 'model/table/PostsTable.class.php';
$postsTable = new PostsTable($db);

// handle the submission
if (isset($_POST['add-post'])) {
    
    // check that title is set
    if (!empty($_POST['title'])) {
        $title = $_POST['title'];
                
        // check that category is set
        if (!empty($_POST['category'])) {
            $category = $_POST['category'];
            
            // get the id of the category
            $categoryId = $postCategoriesTable->getCategoryIdByName($category);
            // check that there is not already a pre-existing title with the same category
            $titleExistsInCategory = $postsTable->titleExistsInCategory($title, $categoryId);
            if (!$titleExistsInCategory) {
                // check that text is set
                if (!empty($_POST['text'])) {
                    $text = $_POST['text'];

                    // insert the post
                    if ($postsTable->addPost($title, $categoryId, $text)) {
                        // increment the count of the category
                        $postCategoriesTable->incrementCount($categoryId);
                    }
                    $addPostMessage = "<p class='failure-message'>New post <em><strong>{$title}</strong></em> successfully added.</p>";
                }
                // text is empty
                else {
                    $addPostMessage = "<p class='failure-message'>Please enter a body for the post.</p>";
                    $jsFocusCode = '$("textarea[name=text]").focus();';
                }
            }
            // a post in the submitted category with submitted title already exists
            else {
                $addPostMessage = "<p class='failure-message'>A post with the title <em><strong>{$title}</strong></em> already exists in the category <em><strong>{$category}</strong></em>.</p>";
                $jsFocusCode = '$("input[name=title]").focus();';
            }
        }
        // category is empty
        else {
            $addPostMessage = "<p class='failure-message'>Please select a <em><strong>category</strong></em> for the post to go under.</p>";
            $jsFocusCode = '$("select[name=category]").focus();';
        }
    }
    // title is empty
    else {
        $addPostMessage = "<p class='failure-message'>Please enter a <em><strong>title</strong></em>.</p>";
        $jsFocusCode = '$("input[name=title]").focus();';
    }
}

$categoryItems = $postCategoriesTable->getCategories();
$out = include_once 'view/admin/add-post-html.php';
return $out;
