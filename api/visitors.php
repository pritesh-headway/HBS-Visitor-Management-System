<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../includes/Database.php';
    include_once '../models/Visitor.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $db = new Database();
        $db = $db->connect();

        $visitorModel = new Visitor($db);

        $input = json_decode(file_get_contents("php://input"));
       
        if (!isset($input->name, $input->office_number, $input->company, $input->reason, $input->employee, $input->phone)) {
            echo json_encode(array('status' => false,'message' => 'All fields are required.'));
        }
        $visitorModel->name = $input->name;
        $visitorModel->office_number = $input->office_number;
        $visitorModel->company = $input->company;
        $visitorModel->reason = $input->reason;
        $visitorModel->employee = $input->employee;
        $visitorModel->phone = $input->phone;
        $visitorData = $visitorModel->postData();

        if ($visitorData) {
            echo json_encode(array('status' => true, 'message' => 'Visitor Added Successfully', 'data' => $chkLogindata));
        } else {
            echo json_encode(array('status' => false,'message' => 'Invalid data, try again!'));
        }
    } else {
        echo json_encode(array('status' => false,'message' => "Error: incorrect Method!"));
    }