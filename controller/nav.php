<?php

// table data gateway class for navigation items
include_once 'model/table/NavItemsTable.class.php';
$navItemsTable = new NavItemsTable($db);

$navItems = $navItemsTable->getNavItems();
$nav = include_once 'view/component/nav-html.php';
return $nav;
