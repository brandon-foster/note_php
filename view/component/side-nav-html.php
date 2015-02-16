<?php
if (!isset($sideNavItems)) {
    trigger_error('Oops: view/component side-nav-html.php needs a $sideNavItems.');
}
$listItemsHTML = '';
while ($item = $sideNavItems->fetch(PDO::FETCH_ASSOC)) {
    $active = '';
    
    if ($_GET['category'] === StringFunctions::formatAsQueryString($item['name'])) {
        $active = "class='active'";
    }
    $href = $item['href'];
    $name = $item['name'];
    $listItemsHTML .= "<li {$active}><a href='{$href}'>{$name}</a></li>";
}
$out = "
<div class='small-12 medium-2 columns'>";
$out .= "
    <ul class='side-nav'>
        {$listItemsHTML}
    </ul>";
$out .= "
</div>";
return $out;
