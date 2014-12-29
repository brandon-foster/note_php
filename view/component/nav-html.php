<?php
$navItemsSet = isset($navItems);
if ($navItemsSet === false) {
    trigger_error('Oops: view/nav-html.php needs $navItems.');
}

// store parent and child items separately
$parentItems = array();
$childrenItems = array();
while ($item = $navItems->fetch(PDO::FETCH_ASSOC)) {
    if ($item['parent_id'] === '0') {
        array_push($parentItems, $item);
    } else {
        array_push($childrenItems, $item);
    }
}

/*
 * Return a slug form of a string.
 * Example:
 * "Admin Panel" becomes 'admin-panel'
 */
function strToSlug($string) {
    $out = strtolower($string);
    str_replace(' ', '-', $out);
    return $out;
}

$navHTML = "";
$size = count($parentItems);
for ($i = 0; $i < $size; $i++) {
    $item = $parentItems[$i];
    
    $linkId = strToSlug($item['name']);
    $href = $item['href'];
    $name = $item['name'];
    
    $navHTML .= "
    <li id='link-{$linkId}' class='has-dropdown'>
        <a href='{$href}'>{$name}</a>";

    
    // for each child, if the child's parent_id matches $item['id'], then create a sub-navigation item
    $navHTML .= "
        <ul class='dropdown'>";
    
    foreach ($childrenItems as $child) {
        if ($child['parent_id'] === $item['id']) {
            $childLinkId = strToSlug($child['name']);
            $childHref = $child['href'];
            $childName = $child['name'];
            
            $navHTML .= "
            <li id='link-{$childLinkId}'>
                <a href='{$childHref}'>
                    {$childName}
                </a>
            </li>";

        }
    }
    $navHTML .= "
        </ul>";
}


// $out = "<pre>PARENT ITEMS<br />";
// $out .= print_r($parentItems, true);
// $out .= "PARENT ITEMS<br />";
// $out .= print_r($childrenItems, true);
// $out .= "</pre>";

return "
<!-- see /js/nav.js -->
<div id='main-nav-row' class='contain-to-grid fixed'>

    <nav class='top-bar' data-topbar>
        <ul class='title-area'>
            <li class='name'>
                <h1>
                    <a href='/'>Login App</a>
                </h1>
            </li>
            <!-- Remove the class 'menu-icon' to get rid of menu icon. Take out 'Menu' to just have icon alone -->
            <li class='toggle-topbar menu-icon'><a href='#'><span>Menu</span></a></li>
        </ul>

        <section class='top-bar-section'>
            <!-- Left Nav Section -->
            <ul class='left'>
                {$navHTML}
            </ul>

        </section>
    </nav>
</div>
<div class='spacer'></div>";
