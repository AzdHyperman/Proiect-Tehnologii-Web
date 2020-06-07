<?php
include_once __DIR__.'/../../config/Database.php'; 
include_once __DIR__.'/Book.php';
include_once __DIR__.'/Comment.php';
include_once __DIR__.'/Vote.php';
include_once __DIR__.'/User.php';


class Review{
    private $conn;
    private $table = 'reviews';

    # class Properties
    public $id;
    public $body;
    public $title;
    public $book;
    public $posted_at;
    public $user;
    public $rating;
    public $votes;
    public $comments;

    public function __construct($body,$title,$book,$user){
        $this->body = $body;
        $this->title = $title;
        $this->book = new Book(null,null,null,null,null);
        $this->book->id = $book;
        $this->book->getBook();
        $this->user = new User(null,null,null,null,null,null,null);
        $this->user->id = $user;
        $this->user->getUser();
    }

    public function getReviews(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;
        //create query
        $query = 'select * from ' . $this->table;
        //prepared statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
    
        //return $stmt;
        if($stmt->rowCount()>0){
            //users array
            $reviews_arr=array(); #date in format json
            $reviews_arr['data']=array(); #datele din json, fara formatul json
        
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row); 
                # in loc sa folosim $row['username'], extract va scoate variabilele
                #si le vom putea folosi ca $username
        
                $review_item = array(
                    'id' => $id,
                    'user_id' => $user_id,
                    'book_id' => $book_id,
                    'body' => $body,
                    'title' => $title,
                    'posting_date' => $posting_date
                );
        
                //push to 'data'
                array_push($reviews_arr['data'], $review_item);
            
            }
            //turn to json
            return json_encode($reviews_arr);
        }else{
            //no users
            return json_encode(
                array('message'=> 'No reviews found')
            );
        
        }
    }

    public function getReview(){
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
        $this->book = new Book(null,null,null,null,null);
        $this->book->title = $row['book_id'];
        $this->book->getBook();

        $this->user = new User(null,null,null,null,null,null,null);
        $this->user->id = $row['user_id'];
        $this->user->getUser();

        //set properties
        $this->body = $row['body'];
        $this->title = $row['title'];
        $this->posted_at = $row['posting_date'];
        $this->id = $row['id'];
        $this->getComments();
        $this->getRating();
        $this->getVotes();
        return true;
        }
        return false;
    }

    public function create(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        //create query
        $query='insert into ' . $this->table . ' set 
        book_id = :book_id,
        user_id = :user_id,
        body = :body,
        title = :title';


        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->book->id = htmlspecialchars(strip_tags($this->book->id));
        $this->user->id = htmlspecialchars(strip_tags($this->user->id));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->title = htmlspecialchars(strip_tags($this->title));


        //bind data
        $stmt->bindParam(':book_id', $this->book->id);
        $stmt->bindParam(':user_id', $this->user->id);
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


    public function update(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

         //create query
         $query= 'update ' .$this->table . ' set body = ?, title = ? ,
         book_id = ? where id = ? and user_id = ?';

         //prepare statement
        //  $stmt = $this->conn->prepare($query);

        //  if($this->book !== null){
        //     $this->book->id = htmlspecialchars(strip_tags($this->book->id));
        //     $stmt->bindParam(3, $this->book->id, PDO::PARAM_INT);
        //  }

        //  if($this->user !== null){
        //     $this->user->id = htmlspecialchars(strip_tags($this->user->id));
        //     $stmt->bindParam(5, $this->user->id, PDO::PARAM_INT);
        //  }

        //  if($this->body !== null){
        //     $this->body= htmlspecialchars(strip_tags($this->body));
        //     $stmt->bindParam(1, $this->body, PDO::PARAM_INT);
        //  }

        //  if($this->title !== null){
        //     $this->title= htmlspecialchars(strip_tags($this->title));
        //     $stmt->bindParam(2, $this->title, PDO::PARAM_INT);
        //  }

        //  if($this->id !== null){
        //     $this->id= htmlspecialchars(strip_tags($this->id));
        //     $stmt->bindParam(4, $this->id, PDO::PARAM_INT);
        //  }
        //  //prepare statement
         $stmt = $this->conn->prepare($query);
        // //clean data
        $this->book->id = htmlspecialchars(strip_tags($this->book->id));
        $this->user->id = htmlspecialchars(strip_tags($this->user->id));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // //bind data
        $stmt->bindParam(3, $this->book->id, PDO::PARAM_INT);
        $stmt->bindParam(4, $this->id, PDO::PARAM_INT);
        $stmt->bindParam(1, $this->body);
        $stmt->bindParam(2, $this->title);
        $stmt->bindParam(5, $this->user->id, PDO::PARAM_INT);


         //execute query
         if($stmt->execute()){
            return true;
        }
        else{
        //print error if something goes wrong in execute
        printf('Error: %s.\n', $this->conn->errorCode());
        return false;
        }
        return false;
    }


    public function delete(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        //create query
        $query = 'delete from ' . $this->table . ' WHERE id=:id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind params
        $stmt->bindParam(':id', $this->id);

        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;

    }

    private function getComments(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        $query = 'SELECT * FROM comments WHERE id_article = ? AND comments.type = "review"';  

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        //execute query
        $result = $stmt->execute();

        $comms_arr = array();

        if($stmt->rowCount()>0){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $comment = new Comment(null,null,null,null,null);
                $comment->id = $id;
                $comment->body = $body;
                $comment->id_article = $this->id;
                $comment->type = $type;
                $comment->user = $user_id;
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

        $query = 'SELECT COUNT(*) AS nr FROM votes WHERE article_id=? AND votes.article_type="review"';

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

        $query = 'SELECT AVG(votes.value) AS nr FROM votes WHERE article_id=? AND article_type="review"';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        if($stmt->rowCount()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->rating = $row['nr'];
        }
    }

    public function vote($value){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        $vote = new Vote($this->id,"review",$value,$this->user->id);
        return $vote->create($this->conn);
    }

    #comment
    public function comment($body,$user_id){
        $database = new Database();
        $db = $database->connect();
        $this->conn = $db;

        $user = new User(null,null,null,null,null,null,null);
        $user->id = $user_id;
        $user->getUser();
        $comment = new Comment($body,$this->id,$this,"review",$user);
        return $comment->create();
    }
    #delete vote??
    #delete comment??
    #update partial

    public function deleteVote($user_id){
        $vote = new Vote($this->id,"review",null,$user_id);
        return $vote->delete();
    }

    public function deleteComment($comment_id){
        // $user = new User(null,null,null,null,null,null,null);
        // $user->id = $user_id;
        // $user->getUser();

        $comment = new Comment(null,null,null,null,null);
        $comment->id = $comment_id;
        $comment->getComment();

        return $comment->delete();
    }


}
