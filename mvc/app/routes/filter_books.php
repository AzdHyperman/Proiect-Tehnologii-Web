<?php
session_start();
require_once ("../controllers/ReviewController.php");
require_once ("../controllers/BookController.php");
session_start();

print_r($_GET);

if(isset($_GET("find")))
{
    $reviewController = new ReviewController();
    $reviews = $reviewController->getReviews();

    $bookController = new BookController();
    $filters = array();
    $result = array();

    if(isset($_GET["title"])){
        $filter = array(
            'filter' => "title",
            'value' => $_GET["title"]);
        array_push($filters,$filter);
    }
    
    if(isset($_GET["author"])){
        //$byAuthor = $bookController->getBooksBy("author_id",$_GET["author"]);
        $filter = array(
            'filter' => "author_id",
            'value' => $_GET["author"]);
        array_push($filters,$filter);
    }

    if(isset($_GET["publishedBy"])){
        //$byPH = $bookController->getBooksBy("publHouse",$_GET["publishedBy"]);
        $filter = array(
            'filter' => "publHouse_id",
            'value' => $_GET["publishedBy"]);
        array_push($filters,$filter);
    }

    if(isset($_GET["year"])){
        //$byYear = $bookController->getBooksByYear("year",$_GET["year"]);
        $filter = array(
            'filter' => "year",
            'value' => $_GET["year"]);
        array_push($filters,$filter);
    }

    $result = $bookController->filter($filters);
    //de afisat!!!!!
}