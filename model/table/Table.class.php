<?php
class Table {
    protected $db = NULL;

    public function __construct($db) {
        $this->db = $db;
    }

    protected function makeStatement($sql, $params=NULL) {
        $statement = $this->db->prepare($sql);

        try {
            $statement->execute($params);
        } catch (Exception $ex) {
            $errorMessage = "<p>Tried to run this SQL: {$sql}. Exception: {$ex}</p>";
            trigger_error($errorMessage);
        }

        return $statement;
    }
}
