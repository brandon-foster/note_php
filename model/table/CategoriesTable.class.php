<?php
include_once 'model/table/Table.class.php';
class CategoriesTable extends Table {
    
    public function getCategories() {
        $sql = '
            SELECT id, name, count
            FROM post_categories';
        
        $result = $this->makeStatement($sql);
        return $result;
    }
}