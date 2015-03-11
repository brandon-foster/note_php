<?php
include_once 'model/table/Table.class.php';
class PostCategoriesTable extends Table {
    public function getCategoryNameById($id) {
        $sql = '
            SELECT name
            FROM post_categories
            WHERE id = :id';
    
        $params = array(
        	':id' => $id
        );
        
        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['name'];

    }
    
    public function addCategory($name) {
        $sql = "
            INSERT INTO post_categories
                (name, count)
            VALUES
                (:name, 0)";
        
        $params = array(
        	'name' => $name
        );
        
        return $this->makeStatement($sql, $params);
    }
    
    public function categoryNameExists($name) {
        $sql = "
            SELECT 1
            FROM post_categories
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
    
    /*
     * Return id, name, and count of all categories
     */
    public function getCategories() {
        $sql = '
            SELECT id, name, count
            FROM post_categories';
    
        $result = $this->makeStatement($sql);
        return $result;
    }
    
    /*
     * Return the category specified by name
     */
    public function getCategoryByName($name) {
        $sql = '
            SELECT id, name, count
            FROM post_categories
            WHERE name = :name';
        
        $params = array(
                ':name' => $name
        );
        
        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch();
        return $row;
    }

    /*
     * Return the category_id of the category with the specified name
     */
    public function getCategoryIdByName($name) {
        $sql = '
            SELECT id
            FROM post_categories
            WHERE name = :name';

        $params = array(
                ':name' => $name
        );

        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }
    
    /*
     * Decrement the count attribute of the category with the specified id
     */
    public function decrementCount($id) {
    	$sql = '
            UPDATE post_categories
            SET count = :count
            WHERE id = :id';
    
    	$count = $this->getCount($id);
    	$count--;
    	$params = array(
    			':count' => $count,
    			':id' => $id
    	);
    
    	$this->makeStatement($sql, $params);
    }
    
    /*
     * Increment the count attribute of the category with the specified id
     */
    public function incrementCount($id) {
        $sql = '
            UPDATE post_categories
            SET count = :count
            WHERE id = :id';
    
        $count = $this->getCount($id);
        $count++;
        $params = array(
                ':count' => $count,
                ':id' => $id
        );

        $result = $this->makeStatement($sql, $params);
        return $result;
    }

    /*
     * Return the count attribute of the category with the specified id
     */
    private function getCount($id) {
        $sql = '
            SELECT count
            FROM post_categories
            WHERE id = :id';

        $params = array(
        	':id' => $id
        );

        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }
}
