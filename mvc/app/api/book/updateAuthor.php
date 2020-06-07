<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Author.php'; #aducem modelele necesare

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem autorii
$author=new Author($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//set ID to update
$author->id = $data->id;

$author->name = $data->name;

//update user
if($author->update()) {
    echo json_encode(
        array('message' => 'Author Updated')
    );
}
else {
    echo json_encode(
        array('message' => 'Author Not Updated')
    );
}

