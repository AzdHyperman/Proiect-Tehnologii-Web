<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Book.php'; #aducem modelele necesare
include_once '../../models/User.php';
include_once '../../models/Review.php';
include_once '../../models/Author.php';


//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem cartile
$review = new Review($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$book=new Book($db);
$book->title = $data->book_id;
$book->getBook();

$user = new User($db);
$user->id = $data->user_id;
$user->getUser();
echo 'User creat';

$review->book = $book;
$review->title = $data->title;
$review->body = $data->body;
$review->user = $user;
#$review->book_id = $data->book_id;
#$review->user_id = $data->user_id;

//create book
if($review->create()) {
    echo json_encode(
        array('message' => 'Review Created')
    );
}
else {
    echo json_encode(
        array('message' => 'Review Not Created')
    );
}

