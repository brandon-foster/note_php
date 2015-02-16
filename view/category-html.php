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
    $postPreviewText = strip_tags($post['preview_text'], '<p>');
    $postDate = $post['date_created'];

    $titleDashed = strtolower($postTitle);
    $titleDashed = StringFunctions::spaceToDash($titleDashed);
    $href = "index.php?page=categories&category={$categoryNameDashed}&title={$titleDashed}";

    $ellipses = (strlen($postPreviewText) === 40) ? '... (<em>read more</em>)' : '';
    $categoryPostsHTML .= "
        <div class='row'>
            <div class='panel'>
                <a href='{$href}'>
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
    <div class='small-12 medium-10 columns'>";
$out .= "
        <div class='row'>
            <h1>{$category['name']}</h1>
            <p>There {$isOrAre} {$quantity} {$postOrPosts} in this category.</p>
        </div>";
$out .= $categoryPostsHTML;
$out .= '</div>';
return $out;