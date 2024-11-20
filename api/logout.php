<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../includes/Database.php';
    include_once '../models/UserDevice.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $db = new Database();
        $db = $db->connect();

        $loginModel = new UserDevice($db);

        $input = json_decode(file_get_contents("php://input"));
       
        if (!isset($input->user_id)) {
            echo json_encode(array('status' => false,'message' => 'User Id is required.'));
        }
        $loginModel->user_id = $input->user_id;
        $chkLogindata = $loginModel->matchUpdate();
        // print_r($chkLogindata); die;
        if($chkLogindata) {
            echo json_encode(array('status' => true, 'message' => 'Log-Out Success', 'data' => []));
        } else {
            echo json_encode(array('status' => false,'message' => 'Please, try again!'));
        }
    } else {
        echo json_encode(array('status' => false,'message' => "Error: incorrect Method!"));
    }