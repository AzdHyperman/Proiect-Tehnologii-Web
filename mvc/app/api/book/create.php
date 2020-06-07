<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Book.php'; #aducem modelele necesare
include_once '../../models/Author.php';

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem cartile
$book = new Book($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$author=new Author($db);
$author->name = $data->author_name;
$author->getAuthorByName();

$book->author = $author;
$book->title = $data->title;
$book->body = $data->body;
$book->posted_at = $data->posted_at;
$book->year = $data->year;

//create book
if($book->create()) {
    echo json_encode(
        array('message' => 'Book Created')
    );
}
else {
    echo json_encode(
        array('message' => 'Book Not Created')
    );
}

