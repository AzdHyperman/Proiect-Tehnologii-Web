<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Book.php'; #aducem modelele necesare
include_once '../../models/Author.php';
include_once '../../models/Comment.php';
include_once '../../models/publishingHouse.php';
include_once '../../models/User.php';
include_once '../../models/Review.php';

/*
{
  "body" : "comentariu trealsjfnd ",
  "id_article" : "2",
  "type" : "book" ,
  "user_id" : "2"
} 
*/

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem cartile
$comment = new Comment($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//verificam daca 
if($data->type === 'book'){
    $book=new Book($db);
    $book->id = $data->id_article;
    $book->getBook();
    $comment->article = $book;
}
else if($data->type === 'review'){
    $review = new Review($db);
    $review->id = $data->id_article;
    $review->getReview();
    $comment->article = $review;
}

$user = new User($db);
$user->id = $data->user_id;
$user->getUser();
$comment->user = $user;

$comment->type = $data->type;
$comment->body = $data->body;

//create comment
if($comment->type != null && $comment->article != null &&  $comment->create()) {
    echo json_encode(
        array('message' => 'Comment Created')
    );
}
else {
    echo json_encode(
        array('message' => 'Comment Not Created')
    );
}

