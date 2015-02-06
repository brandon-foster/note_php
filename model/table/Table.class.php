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
            $errorMessage = "<pre>Tried to run this SQL: {$sql}. Exception: {$ex}</pre>";
            trigger_error($errorMessage);
        }

        return $statement;
    }
}
