<?php
include_once 'model/table/Table.class.php';

class UsersTable extends Table {
    public function getUser($username) {
        $sql = "
            SELECT id, username, password, salt, email
            FROM users
            WHERE username = :username";
        
        $params = array(
        	':username' => $username
        );
        
        return $this->makeStatement($sql, $params);
    }
    
    public function createUser($username, $password, $email) {
        return "User <em>{$username}</em> created.";
    }
}
