<?php
if (!isset($_SESSION['user'])) {
    redirect('admin.php?page=login');
}
if (!isset($uploadMessage)) {
    $uploadMessage = '';
}
if (!isset($selectedNavItem)) {
    $selectedNavItem = '';
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
    if (!empty($selectedNavItem) && $navItemName == $selectedNavItem) {
        $selected = "selected='selected'";
    } else {
        $selected = '';
    }

    $navItemId = $navItem['id'];
    $navItemOptionsHTML .= "<option value='{$navItemId}' {$selected}>{$navItemName}</option>";
}

$out = "
<div class='row center'>
    <div class='signup-panel'>
        <p class='welcome'>Add Navigation</p>
        {$uploadMessage}
        <form action='admin.php?page=add-album' method='POST'>
            <!-- navigation name -->
            <div class='row collapse'>
                <div class='small-2 columns'>
                    <span class='prefix'><i class='fi-folder'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 columns'>
                    <input type='text' name='navigation-name' placeholder='new navigation name' />
                </div>
            </div>

            <!-- navigation parent -->
            <div class='row collapse'>
                <div class='small-2 columns'>
                    <span class='prefix'><i class='fi-folder'></i> <em class='required'></em></span>
                </div>
                <div class='small-10 columns'>
                    <select name='nav-item-id'>
                        <option value='0'>No parent</option>
                        {$navItemOptionsHTML}
                    </select>
                </div>
            </div>
            
            <!-- admin only status -->
            <div class='row collapse'>
                <div class='small-3 columns'>
                    Admin only <em class='required'></em>
                </div>
                <div class='small-9 columns'>
                    <input type='radio' name='admin-only' value='1'>Yes
                    <input type='radio' name='admin-only' value='0'>No
                </div>
            </div>
            <input type='submit' name='add-navigation' value='Add Navigation' class='button' />
        </form>
    </div>
</div>";
return $out;
