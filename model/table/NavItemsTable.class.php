<?php
include_once 'model/table/Table.class.php';

class NavItemsTable extends Table {
    public function getNameById($id) {
        $sql = "
            SELECT name
            FROM nav_items
            WHERE id = :id";

        $params = array(
            ':id' => $id
        );

        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['name'];
    }

    public function navNameExists($name) {
        $sql = "
            SELECT 1
            FROM nav_items
            WHERE name = :name";
        
        $params = array(
                ':name' => $name
        );
        
        $result = $this->makeStatement($sql, $params);
        if ($result->rowCount() != 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function addNavItem($name, $parentId, $hasChild, $href, $adminOnly) {
        $sql = "
            INSERT INTO nav_items
                (name, parent_id, has_child, href, admin_only)
            VALUES
                (:name, :parent_id, :has_child, :href, :admin_only)";

        $params = array(
                ':name' => $name,
                ':parent_id' => $parentId,
                ':has_child' => $hasChild,
                ':href' => $href,
                ':admin_only' => $adminOnly
        );

        $result = $this->makeStatement($sql, $params);
        return $result;
    }

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
    
    public function getTopNavItems() {
        $sql = "
            SELECT id, name, parent_id, has_child, href, admin_only
            FROM nav_items
            WHERE parent_id = :parent_id";
        
        $params = array(
        	':parent_id' => 0
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
