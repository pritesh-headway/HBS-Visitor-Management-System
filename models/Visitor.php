<?php
class Visitor {

    private $conn;
    
    public $name;
    public $office_number;
    public $company;
    public $reason;
    public $employee;
    public $phone;

    public function __construct($db){
        $this->conn = $db;
    }

    public function fetchAll() {
        
        $stmt = $this->conn->prepare('SELECT * FROM students');
        $stmt->execute();
        return $stmt;
    }

    public function postData() {

        $stmt = $this->conn->prepare('INSERT INTO students SET name = :name, address = :address, age = :age');

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':age', $this->age);

        if($stmt->execute()) {
            return TRUE;
        }

        return FALSE;
    }

}