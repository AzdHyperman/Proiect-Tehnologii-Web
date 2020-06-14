<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,commentization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Comment.php'; #aducem modelele necesare

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem autorii
$comment=new Comment($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//set ID to update
$comment->id = $data->id;

$comment->body = $data->body;

//update user
if($comment->update()) {
    echo json_encode(
        array('message' => 'comment Updated')
    );
}
else {
    echo json_encode(
        array('message' => 'comment Not Updated')
    );
}

