<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Comment.php'; #aducem modelele necesare
include_once '../../models/Review.php';
include_once '../../models/Book.php';
include_once '../../models/User.php';

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//get raw posted data
$data = json_decode(file_get_contents("php://input"));
$id = isset($_GET['id'])? $_GET['id']:die();

$comment = new Comment($db);
$comment->id = $id;
$comment->getComment();
//set ID to update

//delete user
if($comment->delete()) {
    echo json_encode(
        array('message' => 'Comment Deleted')
    );
}
else {
    echo json_encode(
        array('message' => 'Comment Not Deleted')
    );
}

