<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Review.php'; #aducem modelele necesare
include_once '../../models/Book.php';
include_once '../../models/User.php';
include_once '../../models/Author.php';

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem review
$review=new Review($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//set ID to update
$review->id = $data->id;

$book = new Book($db);
$book->id = $data->book_id;
$book->getBook();
//print_r($book);

$user = new User($db);
$user->id = $data->user_id;
$user->getUser();
//print_r($user);

$review->title = $data->title;
$review->body = $data->body;
$review->book = $book;
$review->user = $user;
//print_r($data);

//update review
if($review->update()) {
    echo json_encode(
        array('message' => 'Review Updated')
    );
}
else {
    echo json_encode(
        array('message' => 'review Not Updated')
    );
}

