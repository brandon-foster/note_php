<?php
if (!isset($post)) {
    trigger_error('Oops: view/post-html.php needs a $post');
}
// set title
$categoryName = $category['name'];
$pageData->setTitle("Posts &middot; {$categoryName}");
// set body class
$categoryNameLower = strtolower($categoryName);
$categoryNameDashed = StringFunctions::spaceToDash($categoryNameLower);
$pageData->setBodyClass("body-{$categoryNameDashed}");
$out = "
<div class='small-10 columns'>
  <h2>{$post['title']}</h2>
  <p>{$post['date_created']}</p>
  <div>
    {$post['text']}
  </div>
</div>";
return $out;
