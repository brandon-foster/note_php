<?php
include_once 'model/table/Table.class.php';
class PostCategoriesTable extends Table {
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
     * Return the category_id of the category with the specified name
     */
    public function getCategoryIdByName($categoryName) {
        $sql = '
            SELECT id
            FROM post_categories
            WHERE name = :name';

        $params = array(
                ':name' => $categoryName
        );

        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['id'];
    }

    /*
     * Increment the count attribute of the category with the specified id
     */
    public function incrementCount($id) {
        $sql = '
            UPDATE post_categories
            SET count = :count';
    
        $count = $this->getCount($id);
        $count++;
        $params = array(
                ':count' => $count
        );

        $this->makeStatement($sql, $params);
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
