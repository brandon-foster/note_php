<?php
if (!isset($postRow)) {
    trigger_error('Oops: view/admin/edit-post-html.php needs a $postRow');
}
if(!isset($categoryItems)) {
    trigger_error('Oops: view/admin/add-post-html.php needs $categoryItems.');
}
if (!isset($editPostMessage)) {
    $editPostMessage = '';
}
if (!isset($title)) {
    $title = '';
}
if (!isset($categoryId)) {
    $categoryId = '';
}
if (!isset($text)) {
    $text = '';
}
if (!isset($dateCreated)) {
    $dateCreated = '';
}

// add css
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/pretty-form.css');

// javascript input focus code (added to $pageData before return'ed)
// focus on email by default
if (!isset($jsFocusCode)) {
    $jsFocusCode = '$("textarea[name=title]").focus();';
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

$text = htmlentities(htmlspecialchars($postRow['text']));

$out = "
<div class='row center'>
    <div class='signup-panel'>
        <p class='welcome'>Edit Post</p>
        {$editPostMessage}
        
        <form action='' method='POST'>
            <input type='hidden' name='id' value='{$postRow['id']}' />
            
            <!-- title -->
            <div class='row collapse'>
                <div class='small-2 columns'>
                    <span class='prefix'><i class='fi-clipboard'></i> <em class='required'></em></span>
                </div>
                <div class='small-10  columns'>
                    <input type='text' name='title' value='{$postRow['title']}' placeholder='title' maxlength='255' />
                </div>
            </div>
            
            <!-- category -->
            <div class='row collapse'>
                <div class='small-2 columns'>
                    <span class='prefix'><i class='fi-list-thumbnails'></i> <em class='required'></em></span>
                </div>
                <div class='small-10  columns'>
                    <select name='category-name'>
                        <option value=''>Select category</option>
                        {$categoryOptionsHTML}
                    </select>
                </div>
            </div>
            
            <!-- text -->
            <div class='row collapse'>
                <div class='small-2 columns'>
                    <span class='prefix'><i class='fi-pencil'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 columns'>
                    <textarea name='text' placeholder='Edit post...'>{$text}</textarea>
                </div>
            </div>
            
            <!-- date  -->
            <div class='row collapse'>
                <div class='small-2 columns'>
                    <span class='prefix'><i class='fi-pencil'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 columns'>
                    <textarea name='date-created' placeholder='Edit date...'>{$postRow['date_created']}</textarea>
                </div>
            </div>
            
            <!-- edit-post -->
            <input type='submit' name='edit-post' value='Edit post' class='button' />
        </form>
    </div>
</div>";

return $out;
