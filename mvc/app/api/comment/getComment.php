<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Book.php'; #aducem modelele necesare
include_once '../../models/Author.php';
include_once '../../models/Comment.php';
include_once '../../models/publishingHouse.php';
include_once '../../models/User.php';
include_once '../../models/Review.php';


//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem userii
$comment = new Comment($db);
//something.com?id=3 luam 3 din url
//get ID 
$comment->id = isset($_GET['id'])? $_GET['id']:die();

//get user
$comment->getComment();

//create array
$comment_arr=array(
    'id' => $comment->id,
    'type' => $comment->type,
    'body' => $comment->body,
    'user_id' => $comment->user->id,
    'id_article' => $comment->article->id,
    'posted_at' => $comment->posted_at
);

//make json
print_r(json_encode($comment_arr));
