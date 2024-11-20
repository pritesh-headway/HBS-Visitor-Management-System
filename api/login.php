<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../includes/Database.php';
    include_once '../models/Login.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $db = new Database();
        $db = $db->connect();

        $loginModel = new Login($db);

        $input = json_decode(file_get_contents("php://input"));
       
        if (!isset($input->email, $input->password)) {
            echo json_encode(array('status' => false,'message' => 'Email and password are required.'));
        }
        $loginModel->type = $input->type;
        $loginModel->email = $input->email;
        $loginModel->password = $input->password;
        $chkLogindata = $loginModel->matchCredential();
        //  print_r($chkLogindata); die;
        if($chkLogindata) {
            echo json_encode(array('status' => true, 'message' => 'Login Success', 'data' => $chkLogindata));
        } else {
            echo json_encode(array('status' => false,'message' => 'Invalid email and passwword, try again!'));
        }
    } else {
        echo json_encode(array('status' => false,'message' => "Error: incorrect Method!"));
    }