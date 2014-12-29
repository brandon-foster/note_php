<?php
class NavItemsTable {
    private $db = NULL;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getNavItems() {
        $sql = "
            SELECT id, name, parent_id, has_child, href
            FROM nav_items";
        $result = $this->makeStatement($sql);
        return $result;
    }
    
    private function makeStatement($sql, $params=NULL) {
        $statement = $this->db->prepare($sql);
        try {
            $statement->execute($params);
        } catch (Exception $ex) {
            $exceptionMessage = "<p>You attempted to execute this SQL: {$sql}</p>
            <p>Exception: {$ex}</p>";
            trigger_error($exceptionMessage);
        }
        
        // return the PDO statement
        return $statement;
    }
}
