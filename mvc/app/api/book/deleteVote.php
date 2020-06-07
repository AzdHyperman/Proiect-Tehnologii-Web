<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Vote.php'; #aducem modelele necesare

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//get raw posted data
$data = json_decode(file_get_contents("php://input"));
$aid = isset($_GET['article_id'])? $_GET['article_id']:die();
$uid = isset($_GET['user_id'])? $_GET['user_id']:die();
//set ID to update
$vote = new Vote($aid,"book",null,$uid);

//delete user
if($vote->delete($db)) {
    echo json_encode(
        array('message' => 'Vote Deleted')
    );
}
else {
    echo json_encode(
        array('message' => 'Vote Not Deleted')
    );
}

