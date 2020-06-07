<?php
include_once __DIR__.'/../../config/Database.php'; 

class Author{
     #DB stuff
     private $conn;
     private $table = 'authors';
 
     # class Properties
     public $id;
     public $name;

     public function __construct($name){
         $this->name = $name;
     }

     public function create(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

        $query='insert into ' . $this->table . ' set 
        name = :name';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind params
        $stmt->bindParam(':name', $this->name);

        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;

     }

     public function getAuthor(){
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
        $this->name = $row['name'];
        return true;
        }
        return false;
     }

     public function getAuthors(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

         //create query
        $query = 'select * from ' . $this->table;
        //prepared statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        //vf daca sunt useri
        if($stmt->rowCount()>0){
            //users array
            $authors_arr=array(); #date in format json
            $authors_arr['data']=array(); #datele din json, fara formatul json

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row); 
                # in loc sa folosim $row['username'], extract va scoate variabilele
                #si le vom putea folosi ca $username

                $author_item = array(
                    'id'=> $id,
                    'name' => $name
                );

                //push to 'data'
                array_push($authors_arr['data'], $author_item);
            
            }
            //turn to json
            return json_encode($authors_arr);
        }else{
            //no users
            return json_encode(
                array('message'=> 'No authors found')
            );

        }
}

     public function getAuthorByName(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

         //create query
        $query = 'select * from ' . $this->table . ' where name=? limit 0,1';
        //prepare statement
        $stmt = $this->conn->prepare($query);
        //bind ID to prepared stmt
        $stmt->bindParam(1, $this->name);
        //execute query
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->id = $row['id'];
     }

     public function update(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;

         //create query
        $query= 'update ' .$this->table . ' set name = :name where id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        //bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        //execute query
        if($stmt->execute()){
            return true;
        }
        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

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
}