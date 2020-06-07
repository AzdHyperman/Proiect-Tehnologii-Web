<?php

header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

require_once(__DIR__ . '\..\core\Controller.php');
require_once(__DIR__ . '\..\models\Review.php');

class ReviewController extends Controller{
    public $conn;
    public $table = 'reviews';
    public $review;
    //initializez si invoc(=apelez met care trebe) modelul, 

    public function __construct(){}

    public function setReview($body,$title,$book,$user){
        $this->review = new Review($body,$title,$book,$user);
    }

    public function index(){
            $a=new Author(null);
            $authors = $a->getAuthors();
            $authors = json_decode($authors);
            $authors = $authors->data;
            //print_r($authors);
            $ph= new publishingHouse(null,null,null);
            $publishingHouses= json_decode($ph->getPublishingHouses());
            $publishingHouses = $publishingHouses->data;

            $reviews = json_decode($this->getReviews());
            $reviews->authors=array();
            $reviews->publishingHouses=array();
            array_push($reviews->authors,$authors);
            array_push($reviews->publishingHouses,$publishingHouses);
            $this->view('reviews',$reviews);
    }

    public function getReviews(){
        try{
            if($this->review === null){
                $this->review = new Review(null,null,null,null,null,null,null);
            }
            return $this->review->getReviews();
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
                array('message'=> 'User does not exist')
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



}