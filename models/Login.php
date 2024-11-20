<?php
class Login {

    private $conn;
    
    public $type;
    public $email;
    public $password;

    public function __construct($db){
        $this->conn = $db;
    }

    public function fetchAll() {
        
        $stmt = $this->conn->prepare('SELECT * FROM students');
        $stmt->execute();
        return $stmt;
    }

    public function matchCredential() {

        $stmt = $this->conn->prepare('SELECT  * FROM tbladmin WHERE Type = :type AND Email = :email AND Password = :password');
        $type = $this->type;
        $email = $this->email;
        $password = md5($this->password);

        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        $query = $stmt->queryString;
        $query = str_replace([':type', ':email', ':password'], [$type, $email, $password], $query);

        // echo  "Executed Query: " . $query; die;
        $stmt->execute();        

        if($stmt->rowCount() > 0) {
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // $this->id = $row['id'];
            // $this->name = $row['name'];
            // $this->address = $row['address'];
            // $this->age = $row['age'];

            return $row;
        }
        
        return FALSE;
    }
}