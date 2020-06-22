<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Book.php'; #aducem modelele necesare
include_once '../../models/Author.php';
include_once '../../models/Vote.php';
include_once '../../models/Comment.php';
include_once '../../models/publishingHouse.php';
include_once '../../models/Review.php';
include_once '../../models/User.php';

/*
{
  "article_id" : "2",
  "value" : "5"
}
*/

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem cartile
$review = new Review($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$review->id = $data->article_id;
$review->getReview();

//create book
if($review->vote($data->value)) {
    echo json_encode(
        array('message' => 'Review Voted')
    );
}
else {
    echo json_encode(
        array('message' => 'Review Not Voted')
    );
}

