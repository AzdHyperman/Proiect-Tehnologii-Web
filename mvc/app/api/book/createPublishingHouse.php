<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/publishingHouse.php'; #aducem modelele necesare

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem userii
$ph = new publishingHouse($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$ph->name = $data->name;
$ph->country = $data->country;
$ph->founded = $data->founded;

//create author
if($ph->create()) {
    echo json_encode(
        array('message' => 'Publishing House Created')
    );
}
else {
    echo json_encode(
        array('message' => 'Publishing House Not Created')
    );
}

