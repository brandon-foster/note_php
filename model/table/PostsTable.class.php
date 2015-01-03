<?php
include_once 'model/table/Table.class.php';
class PostsTable extends Table {
    
    /*
     * Return posts, with only previews of the text, the first 
     */
    public function getPostsListingByCategoryId($categoryId) {
        $sql = '
            SELECT id, title, category_id, LEFT(text, 40) AS preview_text, date_created
            FROM posts
            WHERE category_id = :category_id';
        
        // get category_id from $category
        $params = array(
                ':category_id' => $categoryId,
        );
        
        $result = $this->makeStatement($sql, $params);
        return $result;
    }

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
