<?php

header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once __DIR__.'/../../config/Database.php'; 
include_once __DIR__.'/User.php';
include_once __DIR__.'/Review.php';
include_once __DIR__.'/Book.php';


class Comment{
    private $conn;
    private $table = 'comments';

    public $body;
    public $id;
    public $id_article;
    public $type;
    public $user;
    public $posted_at;
    public $article;

    public function __construct($body,$aid,$article,$type,$user){
        $this->body = $body;
        $this->article_id = $aid;
        $this->article = $article; 
        $this->type = $type;
        $this->user = $user;
    }

    public function create(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        //create query
        $query='insert into ' . $this->table . ' set 
        id_article = :id_article,
        user_id = :user_id,
        body = :body,
        type = :type';


        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->article->id = htmlspecialchars(strip_tags($this->article->id));
        $this->user->id = htmlspecialchars(strip_tags($this->user->id));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->type = htmlspecialchars(strip_tags($this->type));


        //bind data
        $stmt->bindParam(':id_article', $this->article->id);
        $stmt->bindParam(':user_id', $this->user->id);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':type', $this->type);

        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;
    }

    public function getComment(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        //create query
        $query = 'select * from ' . $this->table . ' where id=? limit 0,1';
        //prepare statement
        $stmt = $this->conn->prepare($query);
        //bind ID to prepared stmt
        $stmt->bindParam(1, $this->id);
        //execute query
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
        $this->type = $row['type'];
           if($this->type === 'book'){
                $this->article = new Book(null,null,null,null,null);
                $this->article->id = $row['id_article'];
                $this->article->getBook();
           }
           else if($this->type === 'review'){
                $this->article = new Review(null,null,null,null,null,null,null);
                $this->article->id = $row['id_article'];
                $this->article->getReview();
           }
        
        $this->user = new User(null,null,null,null,null,null,null,null,null);
        $this->user->id = $row['user_id'];
        $this->user->getUser();

        //set properties
        $this->body = $row['body'];
        $this->posted_at = $row['posted_at'];
        $this->id = $row['id'];
        return true;
        }
        return false;
    }

    //get all comments
    public function getComments(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        //create query
        $query = 'select * from ' . $this->table;
        //prepared statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
    
        if($stmt->rowCount()>0){
            //users array
            $comms_arr = array(); #date in format json
            //$comms_arr['data'] = array(); #datele din json, fara formatul json

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row); 
                # in loc sa folosim $row['username'], extract va scoate variabilele
                #si le vom putea folosi ca $username

                $user = new User(null,null,null,null,null,null,null);
                $user->id = $user_id;
                $user->getUser();
        
                $comment_item = array(
                    'id'=>$id,
                    'body' =>$body,
                    'id_article' => $id_article,
                    'type' => $type,
                    'user' => $user,
                    'posted_at' => $posted_at
                );

                //push to 'data'
                array_push($comms_arr, $comment_item);
            
            }
            //turn to json
            return $comms_arr;
        }else{
            //no users
            return null;

        }
    }

    #update body
    public function update(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

         //create query
         $query= 'update ' .$this->table . ' set body = :name where id = :id';

         //prepare statement
         $stmt = $this->conn->prepare($query);
 
         //clean data
         $this->body = htmlspecialchars(strip_tags($this->body));
         $this->id = htmlspecialchars(strip_tags($this->id));
         
         //bind data
         $stmt->bindParam(':name', $this->body);
         $stmt->bindParam(':id', $this->id);
 
         //execute query
         if($stmt->execute()){
             return true;
 
         //print error if something goes wrong in execute
         printf('Error: %s.\n', $stmt->err);
 
         return false;
      }
    }

    #delete comm
    public function delete(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        //create query
        $query = 'delete from ' . $this->table . ' WHERE id_article=:aid and user_id=:uid and type=:type and id=:id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->article->id = htmlspecialchars(strip_tags($this->article->id));
        $this->user->id = htmlspecialchars(strip_tags($this->user->id));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind params
        $stmt->bindParam(':aid', $this->article->id);
        $stmt->bindParam(':uid', $this->user->id);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':id', $this->id);


        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;
    }


}