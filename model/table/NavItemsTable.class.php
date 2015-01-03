<?php
include_once 'model/table/Table.class.php';

class NavItemsTable extends Table {
    public function getIdByName($name) {
        $sql = "
            SELECT id
            FROM nav_items
            WHERE name = :name";

        $params = array(
                ':name' => $name
        );

        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    /*
     * Return all nav items whose parent_id is $parentId
     */
    public function getNavChildrenOf($parentId) {
        $sql = "
            SELECT id, name, parent_id, has_child, href, admin_only
            FROM nav_items
            WHERE parent_id = :parent_id";
        
        $params = array(
        	':parent_id' => $parentId
        );
        
        $result = $this->makeStatement($sql, $params);
        return $result;
    }
    
    public function getNavItems() {
        $sql = "
            SELECT id, name, parent_id, has_child, href, admin_only
            FROM nav_items";
        $result = $this->makeStatement($sql);
        return $result;
    }
}
