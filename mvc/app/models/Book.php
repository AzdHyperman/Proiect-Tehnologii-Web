<?php
include_once __DIR__.'/../../config/Database.php'; 
include_once __DIR__.'/Comment.php';
include_once __DIR__.'/Vote.php';
include_once __DIR__.'/Author.php';
include_once __DIR__.'/publishingHouse.php';
include_once __DIR__.'/User.php';



class Book{
    #DB stuff
    private $conn;
    private $table = 'books';

    # class Properties
    public $id;
    public $year;
    public $body;
    public $title;
    public $posted_at;
    public $author;
    public $publHouse;
    public $comments;
    public $rating = 0;
    public $votes = 0;

    public function __construct($year,$body,$title,$author,$publHouse){
        $this->year = $year;
        $this->body = $body;
        $this->title = $title;
        $this->author = new Author(null);
        $this->author->id = $author;
        //$this->author->getAuthor();
        $this->publHouse = new publishingHouse(null,null,null);
        $this->publHouse->id = $publHouse;

    }

    public function getBookByName(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        //create query
        $query = 'select * from ' . $this->table . ' where title=? limit 0,1';
        //prepare statement
        $stmt = $this->conn->prepare($query);
        //bind ID to prepared stmt
        $stmt->bindParam(1, $this->title);
        //execute query
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->author = new Author(null);
        $this->author->id = $row['author_id'];
        $this->author->getAuthor();

        $this->publHouse = new publishingHouse(null,null,null);
        $this->publHouse->id = $row['publHouse_id'];
        $this->publHouse->getPublishingHouse();

        $this->year=$row['year'];
        $this->body=$row['body'];
        $this->title=$row['title'];
        $this->posted_at=$row['posted_at'];
        $this->getComments();
    }

    public function getBooks(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        //create query
        $query = 'SELECT * FROM `books`';
        //prepared statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
    
        if($stmt->rowCount()>0){
            //users array
            $books_arr=array(); #date in format json
            $books_arr['data']=array(); #datele din json, fara formatul json

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row); 
                # in loc sa folosim $row['username'], extract va scoate variabilele
                #si le vom putea folosi ca $username
                $author = new Author(null);
                $author->id = $author_id;
                $author->getAuthor();

                $ph = new publishingHouse(null,null,null);
                $ph->id = $publHouse_id;
                $ph->getPublishingHouse();

                $book_item = array(
                    'id' => $id,
                    'author_id' => $author,
                    'publHouse_id' => $ph,
                    'year' => $year,
                    'body' => $body,
                    'title' => $title,
                    'posting_date' => $posting_date
                );

                //push to 'data'
                array_push($books_arr['data'], $book_item);
            
            }
            //turn to json
            //echo json_encode($books_arr);
            return json_encode($books_arr);
            //return $books_arr;
        }else{
            //no users
            return json_encode(
                array('message'=> 'No books found')
            );

        }
    }

    public function getBook(){
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
         //set properties
         $this->id = $row['id'];
         $this->body = $row['body'];
         $this->title = $row['title'];
         $this->year = $row['year'];
         $this->posted_at = $row['posting_date'];
         $this->getComments();
         $this->getVotes();
         $this->getRating();

         $this->author = new Author(null);
         $this->author->id = $row['author_id'];
         $this->author->getAuthor();

         $this->publHouse = new publishingHouse(null,null,null);
         $this->publHouse->id = $row['publHouse_id'];
         $this->publHouse->getPublishingHouse();
         return true;
        }
        return false;
    }


    public function getComments(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        $query = 'SELECT * FROM comments WHERE id_article = ? AND comments.type = "book"';  

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        //execute query
        $result = $stmt->execute();

        $comms_arr = array();

        if($stmt->rowCount()>0){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $user = new User(null,null,null,null,null,null,null);
                $user->id = $user_id;
                $user->getUser();
                $comment = new Comment($body,$this->id,$this,"book",$user);
                $comment->id=$id;
                $comment->posted_at = $posted_at;
        
                array_push($comms_arr, $comment);
            }
        }
        $this->comments = $comms_arr;
    }

    public function getVotes(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        $query = 'SELECT COUNT(*) AS nr FROM votes WHERE article_id=? AND votes.article_type="book"';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        if($stmt->rowCount()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->votes = $row['nr'];
        }
        
    }

    public function getRating(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        $query = 'SELECT AVG(votes.value) AS nr FROM votes WHERE article_id=? AND article_type="book"';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        if($stmt->rowCount()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->rating = $row['nr'];
        }
    }

    #daca autorul exista ii iau id-ul,altfel il inserez in bd si apoi iau id-ul lui
    #daca publicatia nu exista, o inserez si iau id-ul ei
    //post
    public function create(){     
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        //create query
        $query='insert into ' . $this->table . ' set 
        author_id = :author_id,
        publHouse_id = :publHouse_id,
        year = :year,
        body = :body,
        title = :title';


        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->author->id = htmlspecialchars(strip_tags($this->author->id));
        $this->publHouse->id = htmlspecialchars(strip_tags($this->publHouse->id));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->title = htmlspecialchars(strip_tags($this->title));


        //bind data
        $stmt->bindParam(':author_id', $this->author->id);
        $stmt->bindParam(':publHouse_id', $this->publHouse->id);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':title', $this->title);

        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;
    }

    #vote
    //post
    public function vote($value,$user_id){
        $vote = new Vote($this->id,"book",$value,$user_id);
        return $vote->create();
    }

    #delete vote???????? nush daca ne ajuta, putem folosi direct delete din Vote, exemplu api/book/deleteVote.php
    //delete
    public function deleteVote($user_id){
        $vote = new Vote($this->id,"book",null,$user_id);
        return $vote->delete();
    }

    #comment
    //post
    public function comment($body,$user_id){
        $user = new User(null,null,null,null,null,null,null);
        $user->id = $user_id;
        $user->getUser();

        $comment = new Comment($body,$this->id,$this,"book",$user);
        return $comment->create();
    }
    #delete comment
    //delete
    public function deleteComment($comment_id){
        $comment = new Comment(null,null,null,null,null);
        $comment->id = $comment_id;
        $comment->getComment();

        return $comment->delete();
    }

    #update book 
    public function update(){
        
    }
    #update partial book
    


}