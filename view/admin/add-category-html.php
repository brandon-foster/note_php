<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}
if (!isset($uploadMessage)) {
    $uploadMessage = '';
}
if (!isset($newCategoryName)) {
    $newCategoryName = '';
}

// set title
$pageData->setTitle('Add Category');
// set body class
$pageData->setBodyClass('body-add-category');
// add css
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/pretty-form.css');
// javascript input focus code (added to $pageData before return'ed)
// focus on album-name by default
if (!isset($jsFocusCode)) {
    $jsFocusCode = '$("input[name=category-name]").focus();';
}
// set js focus script
$pageData->addScriptCode($jsFocusCode);

$out = "
<div class='row center'>
    <div class='signup-panel'>
        <h2 class='welcome'>Add Category</h2>
        {$uploadMessage}
        <form action='admin.php?page=add-category' method='POST'>
            <!-- category name -->
            <div class='row collapse'>
                <div class='small-2 medium-1 columns'>
                    <span class='prefix'><i class='fi-folder'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 medium-11 columns'>
                    <input type='text' name='category-name' placeholder='Category name' value='{$newCategoryName}' />
                </div>
            </div>
            
            <input type='submit' name='add-category' value='Add Category' class='button' />
        </form>
    </div>
</div>";
return $out;
