<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Book.php'; #aducem modelele necesare
include_once '../../models/Author.php';
include_once '../../models/publishingHouse.php';
include_once '../../models/Comment.php';

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem userii
$book = new Book($db);
//something.com?id=3 luam 3 din url
//get ID 
$book->id = isset($_GET['id'])? $_GET['id']:die();
//get user
$book->getBook();
//print_r($book);

//create array
$book_arr=array(
    'id' => $book->id,
    'title' => $book->title,
    'body' => $book->body,
    'publHouse' => $book->publHouse,
    'author' => $book->author,
    'year' => $book->year,
    'posted_at' => $book->posted_at,
    'votes' => $book->votes,
    'rating' => $book->rating,
    'comments' => array($book->comments)
);

//make json
print_r(json_encode($book));
