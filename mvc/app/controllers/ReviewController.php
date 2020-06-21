<?php

header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

require_once(__DIR__ . '\..\core\Controller.php');
require_once(__DIR__ . '\..\models\Review.php');

class ReviewController extends Controller{
    public $conn;
    public $table = 'reviews';
    public $review;
    private $url;
    //initializez si invoc(=apelez met care trebe) modelul, 

    public function __construct(){
        $this->url = $_REQUEST;
        //print_r($url);
        //$query = parse_url($url, PHP_URL_QUERY);
        //parse_str($query, $this->query_arr);
        //var_dump($this->query_arr);
    }

    public function setReview($body,$title,$book,$user){
        $this->review = new Review($body,$title,$book,$user);
    }

    public function index(){
            
            $this->view('reviews',null);
    }

    public function prepPage(){
        if($this->review === null){
            $this->setReview(null,null,null,null);
        }
            $a=new Author(null);
            $authors = $a->getAuthors();
            //print_r($authors[0]->name);
            $ph = new publishingHouse(null,null,null);
            $publishingHouses= $ph->getPublishingHouses();

            $reviews = array();
            $reviews['reviews'] = array($this->review->getReviews());
            $reviews['authors'] = array($authors);
            $reviews['publishingHouses'] = array($publishingHouses);
            return $reviews;
    }

    public function getReviews(){
        try{
            if($this->review === null){
                $this->review = new Review(null,null,null,null,null,null,null);
            }
            $this->review->getReviews();
            //$this->view('reviews',null);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return;
        }   
    }

    public function getReview($id){
        if($this->review === null){
            $this->setReview(null,null,null,null,null,null,null,null);
        }
        
        $this->review->id = $id;//isset($_GET['id'])? $_GET['id']:die();

        //get review
        $this->review->getReview();
        if($this->review->title !== null){

            $review_arr = array($this->review);

        //make json
        print_r(json_encode($review_arr)); //return cv?
        #MERGE!!!! LA AFISARE
        }
        else{
            echo json_encode(
                array('message'=> 'Review does not exist')
            ); //return din nou?
        }
    }

    //create()
    /*
    {
  "body" : "am scris sho un review,da, iacasa",
  "title" : "minunat review",
  "user_id" : "7",
  "book_id" : "2"
    }
    */
    public function new(){
        $data = json_decode(file_get_contents("php://input"));
        //init user if null
        if($this->review === null){
            $this->setReview($data->body,$data->title,$data->book_id,$data->user_id);
        }
        try{
            $this->review->create();
            //print_r("ok?");
            return true;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function update(){
        $data = json_decode(file_get_contents("php://input"));

        if($this->review === null){
            $this->setReview($data->body,$data->title,$data->book_id,$data->user_id);
        }

        try{
            $this->review->update();
            echo "ok?";
            return true;
        }
        catch (PDOException $e){
            echo $e->getMessage();
            echo "not gut.";
            return false;
        }
    }

    public function delete($id){
        if($this->review === null){
            $this->setReview(null,null,null,null);
        }
        $this->review->id = $id;
        $this->review->getReview();

        if($this->review->title !== null){
            $this->review->delete();
            print_r("ok?");
            return true;
        }
        return false;
    }

    public function vote(){
        $data = json_decode(file_get_contents("php://input"));
        if($this->review === null){
            $this->setReview(null,null,null,null);
        }
        $this->review->id = $data->id;
        $this->review->getReview();
        if($this->review->title !== null){
            $this->review->vote($data->value,$data->user_id);
            //print_r("cred ca e ok");
        }
        else return false;
    }

    public function unvote(){
        $data = json_decode(file_get_contents("php://input"));
        if($this->review === null){
            $this->setReview(null,null,null,null);
        }
        $this->review->id = $data->id;
        $this->review->getReview();
        if($this->review->title !== null){
            $this->review->deleteVote($data->user_id);
            //print_r("cred ca e ok");
        }
        else return false;
    }

    public function comment(){
        $data = json_decode(file_get_contents("php://input"));
        if($this->review === null){
            $this->setReview(null,null,null,null,null);
        }
        $this->review->id = $data->id;
        $this->review->getReview();
        if($this->review->title !== null){
            $this->review->comment($data->body,$data->user_id);
            print_r("cred ca e ok");
        }
        else return false;
    }

   
    public function deleteComment($id){
        if($this->review === null){
            $this->setReview(null,null,null,null,null);
        }
        return $this->review->deleteComment($id);
        
    }

    public function filter(){
        $this->setReview(null,null,null,null);
        
        $bfilters =array();
        $rfilters = array();
        $result = array();
    

        if(isset($this->url["author"]))
        {        
                    
            //BOOK FILTERS
            if(isset($this->url["author"]) && !empty($this->url["author"])){
                //$byAuthor = $bookController->getBooksBy("author_id",$this->url["author"]);
                $filter = array(
                    'filter' => "author_id",
                    'value' => $this->url["author"]);
                array_push($bfilters,$filter);
            }
        
            if(isset($this->url["publishedBy"]) && !empty($this->url["publishedBy"])){
                //$byPH = $bookController->getBooksBy("publHouse",$this->url["publishedBy"]);
                $filter = array(
                    'filter' => "publHouse_id",
                    'value' => $this->url["publishedBy"]);
                array_push($bfilters,$filter);
            }
        
            if(isset($this->url["year"]) && !empty($this->url["year"])){
                //$byYear = $bookController->getBooksByYear("year",$this->url["year"]);
                $filter = array(
                    'filter' => "year",
                    'value' => $this->url["year"]);
                array_push($bfilters,$filter);
            }
        
            if(isset($this->url["book_title"]) && !empty($this->url["book_title"])){
                //$byYear = $bookController->getBooksByYear("year",$this->url["year"]);
                $filter = array(
                    'filter' => "title",
                    'value' => $this->url["book_title"]);
                array_push($bfilters,$filter);
            }
        
        
            //REVIEW FILTERS
            if(isset($this->url['reviewedBy']) && !empty($this->url["reviewedBy"])){
                $filter = array(
                    'filter' => "user_id",
                    'value' => $this->url['reviewedBy']);
                array_push($rfilters,$filter);
            }
        
            if(isset($this->url['title']) && !empty($this->url["title"])){
                $filter = array(
                    'filter' => "title",
                    'value' => $this->url['title']);
                array_push($rfilters,$filter);
            }
        }
        // print_r($this->url);
        // print_r($rfilters);
        // print_r($bfilters);
        
        return $this->review->filter($bfilters,$rfilters);
    }



}