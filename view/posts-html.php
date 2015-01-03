<?php
if (!isset($categoryItems)) {
    trigger_error('Oops: view/posts-html.php needs a $categoryItems.');
}

// set title
$pageData->setTitle('Posts');
// set body class
$pageData->setBodyClass('body-posts');
// css
$pageData->addCss('css/posts.css');

// get each category of posts
$categoriesHTML = '';
while ($item = $categoryItems->fetch(PDO::FETCH_ASSOC)) {

    $quantity = $item['count'];
    $postOrPosts = StringFunctions::singularOrPlural('post', $quantity);
    
    $categoryQueryParam = $item['name'];
    $categoryQueryParam = StringFunctions::spaceToDash($categoryQueryParam);
    $categoryQueryParam = strtolower($categoryQueryParam);
    
    $href = "index.php?page=posts&category={$categoryQueryParam}";
    
    $categoriesHTML .= "
    <div class='row'>
        <div class='panel'>
            <a href='{$href}'>
                <h3>{$item['name']}</h3>
                <p>{$quantity} {$postOrPosts}</p> 
            </a>
        </div>
    </div>
";
}

return $categoriesHTML;
