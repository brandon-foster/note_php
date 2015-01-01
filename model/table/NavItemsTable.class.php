<?php
include_once 'model/table/Table.class.php';

class NavItemsTable extends Table {    
    public function getNavItems() {
        $sql = "
            SELECT id, name, parent_id, has_child, href, admin_only
            FROM nav_items";
        $result = $this->makeStatement($sql);
        return $result;
    }
}
