<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Review.php'; #aducem modelele necesare

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem userii
$review = new Review($db);

//get raw posted data
//$data = json_decode(file_get_contents("php://input"));
$review->id = isset($_GET['id'])? $_GET['id']:die();


//delete user
if($review->delete()) {
    echo json_encode(
        array('message' => 'Review Deleted')
    );
}
else {
    echo json_encode(
        array('message' => 'Review Not Deleted')
    );
}

