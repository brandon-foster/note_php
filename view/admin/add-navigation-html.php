<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}
if (!isset($uploadMessage)) {
    $uploadMessage = '';
}
if (!isset($newNavName)) {
    $newNavName = '';
}
if (!isset($selectedNavParent)) {
    $selectedNavParent = '';
}
if (!isset($navUrl)) {
    $navUrl = '';
}

$hasChildYes = '';
$hasChildNo = '';
if (isset($hasChild)) {
    if ($hasChild == 1) {
        $hasChildYes = "checked='checked'";
    } else {
        $hasChildNo = "checked='checked'";
    }
}

$adminOnlyYes = '';
$adminOnlyNo = '';
if (isset($adminOnly)) {
    if ($adminOnly == 1) {
        $adminOnlyYes = "checked='checked'";
    } else {
        $adminOnlyNo = "checked='checked'";
    }
}

// set title
$pageData->setTitle('Add Navigation');
// set body class
$pageData->setBodyClass('body-add-navigation');
// add css
$pageData->addCss('res/foundation-icons/foundation-icons.css');
$pageData->addCss('css/admin/pretty-form.css');
// javascript input focus code (added to $pageData before return'ed)
// focus on album-name by default
if (!isset($jsFocusCode)) {
    $jsFocusCode = '$("input[name=navigation-name]").focus();';
}
// set js focus script
$pageData->addScriptCode($jsFocusCode);

$navItems = $navItemsTable->getTopNavItems();
$navItemOptionsHTML = '';

while ($navItem = $navItems->fetch(PDO::FETCH_ASSOC)) {
    $navItemName = $navItem['name'];
    if (!empty($selectedNavParent) && $navItemName == $selectedNavParent) {
        $selected = "selected='selected'";
    } else {
        $selected = '';
    }

    $navItemId = $navItem['id'];
    $navItemOptionsHTML .= "<option value='{$navItemId}' {$selected}>{$navItemName}</option>";
}

$hasChildRow = "
    <!-- has child -->
    <div class='row collapse'>
        <div class='small-3 columns'>
            Has child <em class='required'></em>
        </div>
        <div class='small-9 columns'>
            <input type='radio' name='has-child' value='1' {$hasChildYes}>Yes
            <input type='radio' name='has-child' value='0' {$hasChildNo}>No
        </div>
    </div>";

$adminOnlyRow = "
    <!-- admin only -->
    <div class='row collapse'>
        <div class='small-3 columns'>
            Admin only <em class='required'></em>
        </div>
        <div class='small-9 columns'>
            <input type='radio' name='admin-only' value='1' {$adminOnlyYes}>Yes
            <input type='radio' name='admin-only' value='0' {$adminOnlyNo}>No
        </div>
    </div>";

$out = "
<div class='row center'>
    <div class='signup-panel'>
        <p class='welcome'>Add Navigation</p>
        {$uploadMessage}
        <form action='admin.php?page=add-navigation' method='POST'>
            <!-- navigation name -->
            <div class='row collapse'>
                <div class='small-2 columns'>
                    <span class='prefix'><i class='fi-folder'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 columns'>
                    <input type='text' name='nav-name' placeholder='Navigation item name' value='{$newNavName}' />
                </div>
            </div>

            <!-- navigation parent -->
            <div class='row collapse'>
                <div class='small-2 columns'>
                    <span class='prefix'><i class='fi-folder'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 columns'>
                    <select name='nav-parent-id'>
                        <option value='0'>No parent</option>
                        {$navItemOptionsHTML}
                    </select>
                </div>
            </div>
            
            {$adminOnlyRow}
            
            {$hasChildRow}
            
            <!-- navigation url -->
            <div class='row collapse'>
                <div class='small-2 columns'>
                    <span class='prefix'><i class='fi-folder'></i></span>
                </div>
                <div class='small-10 columns'>
                    <input type='text' name='nav-url' placeholder='Navigation URL' value='{$navUrl}' />
                </div>
            </div>
            
            <input type='submit' name='add-nav' value='Add Navigation' class='button' />
        </form>
    </div>
</div>";
return $out;
