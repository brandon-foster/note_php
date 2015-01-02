<?php
include_once 'model/table/Table.class.php';
class PostsTable extends Table {

    public function addPost($title, $categoryId, $text) {
        $sql = '
            INSERT INTO posts (title, category_id, text)
            VALUES (:title, :category_id, :text)';

        // get category_id from $category
        $params = array(
        	':title' => $title,
            ':category_id' => $categoryId,
            ':text' => $text
        );

        $this->makeStatement($sql, $params);
    }
}
