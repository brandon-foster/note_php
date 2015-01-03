<?php
if (!isset($category)) {
    trigger_error('Oops: view/category-html.php needs an object $category.');
}
if (!isset($categoryPosts)) {
    trigger_error('Oops: view/category-html.php needs an object $categoryPosts.');
}


// set title
$categoryName = $category['name'];
$pageData->setTitle("Posts &middot; {$categoryName}");
// set body class
$categoryNameLower = strtolower($categoryName);
$categoryNameDashed = StringFunctions::spaceToDash($categoryNameLower);
$pageData->setBodyClass("body-{$categoryNameDashed}");

$categoryPostsHTML = '';
while ($post = $categoryPosts->fetch(PDO::FETCH_ASSOC)) {
    $postId = $post['id'];
    $postTitle = $post['title'];
    $postPreviewText = $post['preview_text'];
    $postDate = $post['date_created'];

    $titleDashed = strtolower($postTitle);
    $titleDashed = StringFunctions::spaceToDash($titleDashed);
    $href = "index.php?page=posts&category={$categoryNameDashed}&title={$titleDashed}";
    
    $categoryPostsHTML .= "
        <div class='row'>
            <div class='panel'>
                <a href='{$href}'>
                    <h3>{$postTitle}</h3>
                    <p>{$postDate}</p> 
                    <p>{$postPreviewText}</p>
                </a>
            </div>
        </div>";
}

$quantity = $category['count'];
$postOrPosts = StringFunctions::singularOrPlural('post', $quantity);
$out = "
    <div class='row'>
        <h1>{$category['name']}</h1>
        <p>There are {$quantity} {$postOrPosts} in this category.</p>
    </div>";
$out .= $categoryPostsHTML;
return $out;