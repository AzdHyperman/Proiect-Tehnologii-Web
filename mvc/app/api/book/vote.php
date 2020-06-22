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
/*
{
  "article_id" : "2",
  "value" : "1",
  "user_id" : "2"
}
*/
//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem cartile
$book = new Book($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$book->id = $data->article_id;
$book->getBook();

//create book
if($book->vote($data->value,$data->user_id)) {
    echo json_encode(
        array('message' => 'Book Voted')
    );
}
else {
    echo json_encode(
        array('message' => 'Book Not Voted')
    );
}

