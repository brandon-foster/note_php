<?php
if(!isset($categoryItems)) {
    trigger_error('Oops: view/admin/add-post-html.php needs $categoryItems.');
}
if (!isset($addPostMessage)) {
    $addPostMessage = '';
}
if (!isset($title)) {
    $title = '';
}
if (!isset($category)) {
    $category = '';
}
if (!isset($text)) {
    $text = '';
}

// set title
$pageData->setTitle('Add Post');
// set body class
$pageData->setBodyClass('body-add-post');
// add css
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/pretty-form.css');

// javascript input focus code (added to $pageData before return'ed)
// focus on email by default
if (!isset($jsFocusCode)) {
    $jsFocusCode = '$("input[name=title]").focus();';
}

// set js focus script
$pageData->addScriptCode($jsFocusCode);

// get existing categories from CategoriesTable object
$categoryOptionsHTML = '';
while ($item = $categoryItems->fetch(PDO::FETCH_ASSOC)) {
    $categoryName = $item['name'];
    $categoryCount = $item['count'];
    
    // check if $selected was set in controller from previous submission
    if (!empty($selected) && $categoryName == $selected) {
        $selected = "selected='selected'";
    } else {
        $selected = '';
    }
    $categoryOptionsHTML .= "<option value='{$categoryName}' {$selected}>{$categoryName} ({$categoryCount} existing posts)</option>";
}

$out = "
<div class='row center'>
    <div class='signup-panel'>
        <h2 class='welcome'>Add Post</h2>
        {$addPostMessage}
        <form action='' method='POST'>
            <div class='row collapse'>
                <div class='small-2 medium-1 columns'>
                    <span class='prefix'><i class='fi-clipboard'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 medium-11 columns'>
                    <input type='text' name='title' value='{$title}' placeholder='title' maxlength='255' />
                </div>
            </div>
            <div class='row collapse'>
                <div class='small-2 medium-1 columns'>
                    <span class='prefix'><i class='fi-list-thumbnails'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 medium-11 columns'>
                    <select name='category'>
                        <option value=''>Select category</option>
                        {$categoryOptionsHTML}
                    </select>
                </div>
            </div>
            <div class='row collapse'>
                <div class='small-2 medium-1 columns'>
                    <span class='prefix'><i class='fi-pencil'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 medium-11 columns'>
                    <textarea name='text' placeholder='Compose new post...'>{$text}</textarea>
                </div>
            </div>
            <input type='submit' name='add-post' value='Add post' class='button' />
        </form>
    </div>
</div>";

return $out;
