<?php

include_once __DIR__.'/../../config/Database.php'; 


class Vote{
    public $article_id;
    public $article_type;
    public $value;
    public $user_id;

    public function __construct($aid,$type,$val,$uid){
        $this->article_id = $aid;
        $this->article_type = $type;
        $this->value = $val;
        $this->user_id = $uid;
    }

    public function create(){
        $database = new Database();
        $db = $database->connect();

        $query = 'INSERT INTO votes SET 
        votes.article_id = ? ,
        votes.article_type = ?,
        votes.value = ?,
        votes.user_id = ?';

        //prepare statement
        $stmt = $db->prepare($query);

        //clean data
        $this->article_id = htmlspecialchars(strip_tags($this->article_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->value = htmlspecialchars(strip_tags($this->value));
        $this->article_type = htmlspecialchars(strip_tags($this->article_type));

        $vote = $this->getVote();
        if( $vote === null ){
        //bind data
        $stmt->bindParam(1, $this->article_id);
        $stmt->bindParam(4, $this->user_id);
        $stmt->bindParam(3, $this->value);
        $stmt->bindParam(2, $this->article_type);

        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;
    }
    else
        return $this->update();
    }

    private function getVote(){
        $database = new Database();
        $db = $database->connect();

         //create query
         $query = 'select * from votes where article_id=? 
         and article_type=? 
         and user_id=? limit 0,1';
         //prepare statement
         $stmt = $db->prepare($query);
         //bind ID to prepared stmt
         $stmt->bindParam(1, $this->article_id);
         $stmt->bindParam(2, $this->article_type);
         $stmt->bindParam(3, $this->user_id);
         //execute query
         $stmt->execute();
     
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         if($row){
            //set properties
            $vote = new Vote($row['article_id'],$row['article_type'],$row['value'],$row['user_id']);
            return $vote;
        }
         else return null;
    }

    #update
    public function update(){
        $database = new Database();
        $db = $database->connect();

         //create query
         $query= 'update votes set value = :value where article_id = :aid and user_id=:uid and article_type=:type';

         //prepare statement
         $stmt = $db->prepare($query);
 
         //clean data
         $this->value = htmlspecialchars(strip_tags($this->value));
         $this->article_id = htmlspecialchars(strip_tags($this->article_id));
         $this->user_id = htmlspecialchars(strip_tags($this->user_id));
         $this->article_type = htmlspecialchars(strip_tags($this->article_type));
         
         //bind data
         $stmt->bindParam(':value', $this->value);
         $stmt->bindParam(':aid', $this->article_id);
         $stmt->bindParam(':uid', $this->user_id);
         $stmt->bindParam(':type', $this->article_type);

 
         //execute query
         if($stmt->execute()){
             return true;
 
         //print error if something goes wrong in execute
         printf('Error: %s.\n', $stmt->err);
 
         return false;
      }
    }

    #delete
    public function delete(){
        $database = new Database();
        $db = $database->connect();

        //create query
        $query = 'delete from votes WHERE article_id=? and user_id=? and article_type=?';

        //prepare statement
        $stmt = $db->prepare($query);

        //clean data
        $this->article_id = htmlspecialchars(strip_tags($this->article_id));
        $this->article_type = htmlspecialchars(strip_tags($this->article_type));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        //bind params
        $stmt->bindParam(1, $this->article_id);
        $stmt->bindParam(2, $this->user_id);
        $stmt->bindParam(3, $this->article_type);


        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;

     }


}