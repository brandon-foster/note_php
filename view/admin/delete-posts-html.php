<?php
if (!isset($postRows)) {
    trigger_error('Oops: view/admin/delete-posts-html.php needs a $postRows');
}
if (!isset($deleteMessage)) {
	$deleteMessage = '';
}

// set title
$pageData->setTitle('Delete Posts');
// set body class
$pageData->setBodyClass('body-delete-posts');

// add css
$pageData->addCss('css/admin/pretty-form.css');

$listPosts= "
<form action='' method='POST'>
<ul class='no-bullet'>";


$oldCategoryName = '';
while ($postRow = $postRows->fetch(PDO::FETCH_ASSOC)) {
    $listPosts .= '<li>';

    $id = $postRow['id'];
    $title = $postRow['title'];
    $categoryId = $postRow['category_id'];
    $text = strip_tags($postRow['preview_text'], '<p>');
    $dateCreated = $postRow['date_created'];
    
    $categoryName = $postCategoriesTable->getCategoryNameById($categoryId);
    
    if ($categoryName !== $oldCategoryName) {
        $listPosts .= "<h3>{$categoryName}</h3>";
        $oldCategoryName = $categoryName;
    }

    $listPosts .= "
		<input type='checkbox' name='postsToDelete[]' value='{$id}' />
            <div class='panel'>
                <h4>{$title}</h4>
                <p><i>{$text}</i></p>
                <p>{$dateCreated}</p>
            </div>";

    $listPosts .= '</li>';
}

$listPosts .= "
</ul>
<input type='submit' name='delete-posts' value='Delete posts' class='button' />
</form>";

$out = "
<div class='row center'>
        <h2 class='welcome'>Delete Posts</h2>
		{$deleteMessage}";

$out .= $listPosts;

$out .= '
</div>';

return $out;
