<?php
if (!isset($postRows)) {
    trigger_error('Oops: view/admin/edit-posts-html.php needs a $postRows');
}


// set title
$pageData->setTitle('Edit Post');
// set body class
$pageData->setBodyClass('body-edit-post');

$listPosts= '
<ul class="no-bullet">';


$oldCategoryName = '';
while ($postRow = $postRows->fetch(PDO::FETCH_ASSOC)) {
    $listPosts .= '<li>';

    $id = $postRow['id'];
    $title = $postRow['title'];
    $categoryId = $postRow['category_id'];
    $text = $postRow['preview_text'];
    $dateCreated = $postRow['date_created'];
    
    $categoryName = $postCategoriesTable->getCategoryNameById($categoryId);
    
    if ($categoryName !== $oldCategoryName) {
        $listPosts .= "<h3>{$categoryName}</h3>";
        $oldCategoryName = $categoryName;
    }

    $listPosts .= "
        <a href='admin.php?page=edit-post&id={$id}'>
            <div class='panel'>
                <h4>{$title}</h4>
                <p><i>{$text}...</i></p>
                <p>{$dateCreated}</p>
            </div>
        </a>";

    $listPosts .= '</li>';
}

$listPosts .= '
</ul>';

$out = "
<div class='row'>
    <div class='small-12 columns'>";

$out .= $listPosts;

$out .= '
    </div>
</div>';

return $out;
