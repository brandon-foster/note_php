<?php
$navItemsSet = isset($navItems);
if ($navItemsSet === false) {
    trigger_error('Oops: view/nav-html.php needs $navItems.');
}

// store parent and child items separately
$parentItems = array();
$childrenItems = array();
while ($item = $navItems->fetch(PDO::FETCH_ASSOC)) {
    // if the item is admin only, skip it if the user is not logged in
    if (!($item['admin_only'] && !isset($_SESSION['user']))) {
        if ($item['parent_id'] === '0') {
            array_push($parentItems, $item);
        } else {
            array_push($childrenItems, $item);
        }
    }
}

$navJsCode = "";

$rightNavHTML = "";
$leftNavHTML = "";
$size = count($parentItems);
for ($i = 0; $i < $size; $i++) {
    $item = $parentItems[$i];
    
    $linkId = StringFunctions::spaceToDash($item['name']);
    $linkId = strtolower($linkId);
    $href = $item['href'];
    $name = $item['name'];
    
    $hasChild = ($item['has_child'] === '1' ? true : false);
    if ($hasChild) {
        $dropDownClass = "class='has-dropdown'";
    } else {
        $dropDownClass = "";
    }
    
    $navJsCode .= "
        $('body.body-{$linkId} li#link-{$linkId}').addClass('active');
    ";
    
    $itemHTML = "";
    $itemHTML .= "
    <li id='link-{$linkId}' {$dropDownClass}>
        <a href='{$href}'>{$name}</a>";

    
    // for each child, if the child's parent_id matches $item['id'], then create a sub-navigation item
    if ($hasChild) {
        $itemHTML .= "
            <ul class='dropdown'>";
        
        foreach ($childrenItems as $child) {
            if ($child['parent_id'] === $item['id']) {
                $childLinkId = StringFunctions::spaceToDash($child['name']);
                $childLinkId = strtolower($childLinkId);
                $childHref = $child['href'];
                $childName = $child['name'];
                
                $navJsCode .= "
                $('body.body-{$childLinkId} li#link-{$childLinkId}').addClass('active');
                ";
                
                $itemHTML .= "
                <li id='link-{$childLinkId}'>
                    <a href='{$childHref}'>
                        {$childName}
                    </a>
                </li>";
        
            }
        }
        $itemHTML .= "
            </ul>";
    }
    
    $itemHTML .= "
    </li>";
    
    // append the itemHTML to the appropriate *NavHTML
    if ($item['admin_only']) {
        $rightNavHTML .= $itemHTML;
    } else {
        $leftNavHTML .= $itemHTML;
    }
}

$pageData->addScriptCode($navJsCode);

return "
<!-- see /js/nav.js -->
<div id='main-nav-row' class='contain-to-grid fixed'>

    <nav class='top-bar' data-topbar role='navigation'>
        <ul class='title-area'>
            <li class='name'>
                <h1>
                    <a href='./'>Notes</a>
                </h1>
            </li>
            <!-- Remove the class 'menu-icon' to get rid of menu icon. Take out 'Menu' to just have icon alone -->
            <li class='toggle-topbar menu-icon'><a href='#'><span>Menu</span></a></li>
        </ul>

        <section class='top-bar-section'>
            <!-- Right Nav Section -->
            <ul class='right'>
                {$rightNavHTML}
            </ul>        
        
            <!-- Left Nav Section -->
            <ul class='left'>
                {$leftNavHTML}
            </ul>

        </section>
    </nav>
</div>
<div class='spacer'>&nbsp;</div>";
