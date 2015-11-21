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
// add css
$pageData->addCss('./css/category.css');
// add js
$pageData->addJs('./js/category/category.js');

$categoryPostsHTML = '';
while ($post = $categoryPosts->fetch(PDO::FETCH_ASSOC)) {
    $postId = $post['id'];
    $postTitle = $post['title'];
    $postPreviewText = strip_tags($post['preview_text'], '<p>');
    $postDate = $post['date_created'];

    $titleDashed = strtolower($postTitle);
    $titleDashed = StringFunctions::spaceToDash($titleDashed);
    $href = "./index.php?page=categories&category={$categoryNameDashed}&title={$titleDashed}";

    $ellipses = (strlen($postPreviewText) === 40) ? '... (<em>read more</em>)' : '';
    
    if (isset($_SESSION['user'])) {
        $deleteButton = "<i class='fi-trash modification-action delete-post' data-post-id='{$postId}'></i>";
    } else {
        $deleteButton = '';
    }
    
    $categoryPostsHTML .= "
        <div class='row'>
            <div class='panel'>
                {$deleteButton}
                <a class='anchor' href='{$href}'>
                    <h3>{$postTitle}</h3>
                    <p>{$postDate}</p> 
                    <p>{$postPreviewText}{$ellipses}</p>
                </a>
            </div>
        </div>";
}

$quantity = $category['count'];
$postOrPosts = StringFunctions::singularOrPlural('post', $quantity);
$isOrAre = StringFunctions::isOrAre($quantity);
$out = "
    <div id='category-posts' class='small-12 medium-10 columns'>";
$out .= "
        <div class='row'>
            <h1>{$category['name']}</h1>
            <p>There <span id='quantity-description'>{$isOrAre} <span id='quantity'>{$quantity}</span> {$postOrPosts}</span> in this category.</p>
        </div>";
$out .= $categoryPostsHTML;
$out .= '</div>';
return $out;