<?php
include_once 'model/table/Table.class.php';

class UsersTable extends Table {
    public function validateLogin($username, $userPassword) {
        // get salt from the user
        $salt = $this->getSaltByUsername($username);

        $correctHash = $this->getHashByUsername($username);

        // check if the stored hash in the user table matches the 
        // generated hash of the user-submitted $userPassword and the
        // $username's salt
        $userHash = $this->makeSaltedHash($userPassword, $salt);

        if ($correctHash === $userHash) {
            return true;
        }
        return false;        
    }
    
    public function emailExists($email) {
        $sql = "
            SELECT 1
            FROM users
            WHERE email = :email";
    
        $params = array(
                ':email' => $email
        );
    
        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch();
    
        if ($row === false) {
            return false;
        }
        return true;
    }

    public function usernameExists($username) {
        $sql = "
            SELECT 1
            FROM users
            WHERE username = :username";

        $params = array(
        	':username' => $username
        );

        $result = $this->makeStatement($sql, $params);
        $row = $result->fetch();
        
        if ($row === false) {
            return false;
        }
        return true;
    }

    public function getUserByName($name) {
        $sql = "
            SELECT id, username, hash, salt, email
            FROM users
            WHERE username = :username";
        
        $params = array(
        	':username' => $name
        );
        
        return $this->makeStatement($sql, $params);
    }
    
    public function createUser($username, $password, $email) {
        $sql = "
            INSERT INTO users (
                username, hash, salt, email
            ) VALUES (
                :username,
                :hash,
                :salt,
                :email
            )";
        
        // generate a random salt, to protect against brute force attacks
        // and rainbow table attacks
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $hash = $this->makeSaltedHash($password, $salt);

        $params = array(
        	':username' => $username,
            ':hash' => $hash,
            ':salt'     => $salt,
            ':email'    => $email
        );

        return $this->makeStatement($sql, $params);
    }

    private function makeSaltedHash($password, $salt) {
        // hash the password with the salt so it can be stored securely in your database
        $hash = hash('sha256', $password . $salt);

        // hash the hash 65536 (2^16) times to protect against brute force
        // attacks. The attacker has to compute the hash 65537 times for each
        // guess they make
        for ($round = 0; $round < 65536; $round++) {
            $hash = hash('sha256', $hash . $salt);
        }

        return $hash;
    }
    
    private function getSaltByUsername($username) {
        $sql = '
            SELECT salt
            FROM users
            WHERE username = :username';
        
        $params = array(
        	':username' => $username
        );
        
        $statement = $this->makeStatement($sql, $params);
        $row = $statement->fetch();
        return $row['salt'];
    }
    
    private function getHashByUsername($username) {
        $sql = '
            SELECT hash
            FROM users
            WHERE username = :username';
        
        $params = array(
        	':username' => $username
        );
        
        $statement = $this->makeStatement($sql, $params);
        $row = $statement->fetch();
        return $row['hash'];
    }
}
