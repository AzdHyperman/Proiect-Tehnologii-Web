<?php
require_once (__DIR__."/../controllers/ReviewController.php");
require_once (__DIR__."/../controllers/BookController.php");
require_once (__DIR__."/../core/Controller.php");

if(isset($_GET["find"]))
{
    $reviewController = new ReviewController();
    //$reviews = $reviewController->getReviews();

    $bookController = new BookController();
    $bfilters =array();
    $rfilters = array();
    $result = array();

    
    //BOOK FILTERS
    if(isset($_GET["author"]) && !empty($_GET["author"])){
        //$byAuthor = $bookController->getBooksBy("author_id",$_GET["author"]);
        $filter = array(
            'filter' => "author_id",
            'value' => $_GET["author"]);
        array_push($bfilters,$filter);
    }

    if(isset($_GET["publishedBy"]) && !empty($_GET["publishedBy"])){
        //$byPH = $bookController->getBooksBy("publHouse",$_GET["publishedBy"]);
        $filter = array(
            'filter' => "publHouse_id",
            'value' => $_GET["publishedBy"]);
        array_push($bfilters,$filter);
    }

    if(isset($_GET["year"]) && !empty($_GET["year"])){
        //$byYear = $bookController->getBooksByYear("year",$_GET["year"]);
        $filter = array(
            'filter' => "year",
            'value' => $_GET["year"]);
        array_push($bfilters,$filter);
    }

    if(isset($_GET["book_title"]) && !empty($_GET["book_title"])){
        //$byYear = $bookController->getBooksByYear("year",$_GET["year"]);
        $filter = array(
            'filter' => "title",
            'value' => $_GET["book_title"]);
        array_push($bfilters,$filter);
    }


    //REVIEW FILTERS
    if(isset($_GET['reviewedBy']) && !empty($_GET["reviewedBy"])){
        $filter = array(
            'filter' => "user_id",
            'value' => $_GET['reviewedBy']);
        array_push($rfilters,$filter);
    }

    if(isset($_GET['title']) && !empty($_GET["title"])){
        $filter = array(
            'filter' => "title",
            'value' => $_GET['title']);
        array_push($rfilters,$filter);
    }

    $result = $reviewController->prepPage();
    $result['reviews'] = null;
    $result['reviews'] = $reviewController->filter($bfilters,$rfilters);

    echo $result;

    //print_r($result);

    //$reviewController->view('reviews',$result);
    
}