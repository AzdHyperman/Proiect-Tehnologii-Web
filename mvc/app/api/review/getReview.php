<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Review.php'; #aducem modelele necesare
include_once '../../models/Book.php';
include_once '../../models/User.php';
include_once '../../models/Author.php';
include_once '../../models/Comment.php';


//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem review-urile
$review = new Review($db);
//something.com?id=3 luam 3 din url
//get ID 
$review->id = isset($_GET['id'])? $_GET['id']:die();

//get user
$review->getReview();

//create array
$review_arr=array(
    'id' => $review->id,
    'book_id' => $review->book->id,
    'user_id' => $review->user->id,
    'title' => $review->title,
    'body' => $review->body,
    'posting_date' => $review->posted_at,
    'rating' => $review->rating,
    'votes' => $review->votes,
    'comments' => array($review->comments)
);
//make json
print_r(json_encode($review_arr));
