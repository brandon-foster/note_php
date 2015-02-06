<?php
include_once 'model/table/Table.class.php';
class PostsTable extends Table {
    
    public function getCategoryIdByPostId($id) {
        $sql = '
            SELECT category_id
            FROM posts
            WHERE id = :id';

        $params = array(
        	':id' => $id
        );

        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['category_id'];
    }
    
    public function editPostById($id, $title, $categoryId, $text, $dateCreated) {
        $sql = '
            UPDATE posts
            SET
                title = :title,
                category_id = :category_id,
                text = :text,
                date_created = :date_created
            WHERE id = :id';

        $params = array(
                ':id' => $id,
                ':title' => $title,
                ':category_id' => $categoryId,
                ':text' => $text,
                ':date_created' => $dateCreated
        );

        $result = $this->makeStatement($sql, $params);
        return $result;
    }
    
    public function titleExistsInCategory($title, $categoryId) {
        $sql = '
            SELECT id
            FROM posts
            WHERE title = :title
                AND category_id = :category_id';
        
        $params = array(
                ':title' => $title,
                ':category_id' => $categoryId
                
        );

        $result = $this->makeStatement($sql, $params);
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getPostById($id) {
        $sql = '
            SELECT id, title, category_id, text, date_created
            FROM posts
            WHERE id = :id';
        
        $params = array(
                ':id' => $id
        );
        
        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    
    public function getPostByName($title) {
        $sql = '
            SELECT id, title, category_id, text, date_created
            FROM posts
            WHERE title = :title';
        
        $params = array(
                ':title' => $title
        );
        
        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    
    /*
     * Return all posts, with only previews of the text
     */
    public function getPostsListing() {
        $sql = '
            SELECT id, title, category_id, LEFT(text, 40) AS preview_text, date_created
            FROM posts';
        
        $result = $this->makeStatement($sql);
        return $result;
    }
    
    /*
     * Return posts, with only previews of the text, specified by $categoryId
     */
    public function getPostsListingByCategoryId($categoryId) {
        $sql = '
            SELECT id, title, category_id, LEFT(text, 40) AS preview_text, date_created
            FROM posts
            WHERE category_id = :category_id';
        
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

        return $this->makeStatement($sql, $params);
    }
}
