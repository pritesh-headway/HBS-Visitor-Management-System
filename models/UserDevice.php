<?php
class UserDevice {

    private $conn;
    
    public $user_id;
    public $device_type;
    public $device_token;
    public $api_version;
    public $app_version;
    public $os_version;
    public $device_model_name;

    public function __construct($db){
        $this->conn = $db;
    }

    public function fetchAll() {
        
        $stmt = $this->conn->prepare('SELECT * FROM students');
        $stmt->execute();
        return $stmt;
    }

    public function matchUpdate() {

        $stmt = $this->conn->prepare('SELECT  * FROM user_device WHERE UserId = :user_id AND Status = :status');
        $user_id = $this->user_id;
        $status = 1;

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':status', $status);

        $query = $stmt->queryString;
        $query = str_replace([':user_id', ':status'], [$user_id, $status], $query);

        // echo  "Executed Query: " . $query; die;
        $stmt->execute();        

        if($stmt->rowCount() > 0) {
            
            $stmt = $this->conn->prepare('UPDATE user_device SET Status = "0" WHERE UserId = :user_id');

            $stmt->bindParam(':user_id', $this->user_id);
            if($stmt->execute()) {
                return TRUE;
            }
        }
        
        return TRUE;
    }

    public function postData() {

        $stmt = $this->conn->prepare('INSERT INTO user_device SET UserId = :user_id, DeviceType = :device_type, DeviceToken = :device_token, ApiVersion = :api_version, AppVersion = :app_version, OsVersion = :os_version, DeviceModelName = :device_model_name');

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':device_type', $this->device_type);
        $stmt->bindParam(':device_token', $this->device_token);
        $stmt->bindParam(':api_version', $this->api_version);
        $stmt->bindParam(':app_version', $this->app_version);
        $stmt->bindParam(':os_version', $this->os_version);
        $stmt->bindParam(':device_model_name', $this->device_model_name);

        if($stmt->execute()) {
            return TRUE;
        }

        return FALSE;
    }
}