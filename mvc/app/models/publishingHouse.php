<?php
include_once __DIR__.'/../../config/Database.php'; 

header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

class publishingHouse{
    private $conn;
    private $table = 'publishinghouses';

    public $id;
    public $name;
    public $country;
    public $founded;

    public function __construct($name,$country,$founded){
        $this->name= $name;
        $this->country = $country;
        $this->founded = $founded;
    }

    public function create(){
        $database = new Database();
        $db = $database->connect();
        $this->conn = $db;

        //create query
        $query='insert into ' . $this->table . ' set 
        name = :name,
        country = :country,
        founded = :founded';


        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->founded = htmlspecialchars(strip_tags($this->founded));


        //bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':founded', $this->founded);

        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;
    }

    public function getPublishingHouse(){
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
         $this->country = $row['country'];
         $this->founded = $row['founded'];
         return true;
         }
         return false;
    } 

    public function getPublishingHouses(){
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
            $phs_arr = array(); #date in format json
            //$phs_arr['data'] = array(); #datele din json, fara formatul json

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row); 
                # in loc sa folosim $row['username'], extract va scoate variabilele
                #si le vom putea folosi ca $username

                $ph_item = array(
                    'id'=> $id,
                    'name' => $name,
                    'country' => $country,
                    'founded' => $founded
                );

                //push to 'data'
                array_push($phs_arr, $ph_item);
            
            }
            //turn to json
            return $phs_arr;
        }else{
            //no users
            return null;

        }
    }

            #update 
            #delete
}