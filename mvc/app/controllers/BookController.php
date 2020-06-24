<?php
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

require_once(__DIR__ . '\..\core\Controller.php');
require_once(__DIR__ . '\..\models\User.php');
require_once(__DIR__ . '\..\models\Vote.php');
require_once(__DIR__ . '\..\models\Comment.php');
require_once(__DIR__ . '\..\models\Book.php');

class BookController extends Controller{
    public $conn;
    public $table = 'books';
    public $book;

    public function __construct(){}

    public function setBook($year,$body,$title,$author,$publHouse){
        $this->book = new Book($year,$body,$title,$author,$publHouse);
    }
    public function index(){
        //print_r($this->all());
        $this->view('home',$this->all());
    }
    //getBooks
    public function all(){
        try{
            $this->book = new Book(null,null,null,null,null);
            $books = $this->book->getBooks();
            //$this->view('home',$books);
            //print_r($books);
            return $books;
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    //getBook
    public function item($id){
        if($this->book === null){
            $this->setBook(null,null,null,null,null);
        }
        $this->book->id = $id;//isset($_GET['id'])? $_GET['id']:die();

        //get user
        $this->book->getBook();
        //print_r($this->book);
        if($this->book->title){

        $book_arr = array($this->book);
        //make json
        $this->view('BookPage',$book_arr); //return $book_arr;
        //nu afiseaza ok $book_arr pentru ca contine si alte obiecte decat date din BD
        }
        else{
            echo json_encode(
                array('message'=> 'Book does not exist')
            ); 
        }
    }

    //create()
    // {
    //     "title" : "carte2",
    //     "body" : "o descriere la carte,da",
    //     "year" : "2014",
    //     "author" : "3",
    //     "publHouse" : "3" 
    //   }
    public function new(){
        $data = json_decode(file_get_contents("php://input"));
        //init user if null
        if($this->book === null){
            $this->setBook($data->year,$data->body,$data->title,$data->author,$data->publHouse);
        }
        try{
            $this->book->create();
            return true;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //vote()
    // {
    //     "id" : "2",
    //     "value" : "4",
    //     "user_id" : "3"
    //   }
    public function vote(){
        $data = json_decode(file_get_contents("php://input"));
        if($this->book === null){
            $this->setBook(null,null,null,null,null);
        }
        $this->book->id = $data->id;
        $this->book->getBook();
        if($this->book->title !== null){
            $this->book->vote($data->value,$data->user_id);
            //print_r("cred ca e ok");
        }
        else return false;
    }

    //deleteVote()
    // {
    //     "id" : "2",
    //     "user_id" : "3"
    // }
    public function unvote(){
        $data = json_decode(file_get_contents("php://input"));
        if($this->book === null){
            $this->setBook(null,null,null,null,null);
        }
        $this->book->id = $data->id;
        $this->book->getBook();
        if($this->book->title !== null){
            $this->book->deleteVote($data->user_id);
            //print_r("cred ca e ok");
        }
        else return false;
    }
    
    /*{
     "id" : "2",
     "body" : "comentez si eu pe aici pramandhsndn",
     "user_id" : "3"
    }
    */ 
    public function comment(){
        $data = json_decode(file_get_contents("php://input"));
        if($this->book === null){
            $this->setBook(null,null,null,null,null);
        }
        $this->book->id = $data->id;
        $this->book->getBook();
        if($this->book->title !== null){
            $this->book->comment($data->body,$data->user_id);
            //print_r("cred ca e ok");
        }
        else return false;
    }

    /*
     {
	"id" : "2",
	"user_id" : "3",
    "comment_id" : "6"
    }
     */

    public function deleteComment($id){
        if($this->book === null){
            $this->setBook(null,null,null,null,null);
        }
        return $this->book->deleteComment($id);
    }
    #delete


    public function filter($filters){
        // $filters = array();
        // $filter=array('filter'=>"author_id",'value'=>2);
        // array_push($filters,$filter);
        // $filter=array('filter'=>"year",'value'=>2014);
        // array_push($filters,$filter);
        $this->setBook(null,null,null,null,null);
        return $this->book->getBooksBy($filters);
    }



}