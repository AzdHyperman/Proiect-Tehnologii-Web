<?php
include_once __DIR__.'/../../config/Database.php'; 
#__DIR__ returneaza directorul curent, iar pt a evita probleme cu path-ul, atasam path-ul relativ la fisierul curent
class User{
    #DB stuff
    private $conn;
    private $table = 'users';

    # class Properties
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $email;
    public $birthday;
    public $gender;

    #constructor with DB

    public function __construct($name,$pass,$fname,$lname,$email,$date,$gender){
        $this->username = $name;
        $this->password = $pass;
        $this->first_name = $fname;
        $this->last_name = $fname;
        $this->birthday = $date;
        $this->email = $email;
        $this->gender = $gender;
    }

    public function setDB($db){
        $this->conn = $db;
    }

    //public function __construct(){}

    #get user
    public function getUsers(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;
        //create query
        $query = 'select * from ' . $this->table;
        //prepared statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
    
        $num = $stmt->rowCount();

        //vf daca sunt useri
        if($num>0){
            //users array
            $users_arr=array(); #date in format json
            $users_arr['data']=array(); #datele din json, fara formatul json

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row); 
                # in loc sa folosim $row['username'], extract va scoate variabilele
                #si le vom putea folosi ca $username

                $user_item = array(
                    'id'=>$id,
                    'username' =>$username,
                    'password' => $password,
                    'last_name' => $last_name,
                    'first_name ' => $first_name,
                    'email' => $email,
                    'birthday' => $birthday,
                    'gender' => $gender
                );

                //push to 'data'
                array_push($users_arr['data'], $user_item);
            
            }
            //turn to json
            return json_encode($users_arr); //return stuff
        }else{
            //no users
            return json_encode(
                array('message'=> 'No users found')
            );

        }
    }

    //get single user
    public function getUser(){
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
        $this->username=$row['username'];
        $this->password = $row['password'];
        $this->first_name=$row['first_name'];
        $this->last_name=$row['last_name'];
        $this->email=$row['email'];
        $this->gender=$row['gender'];
        $this->birthday=$row['birthday'];
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
        username = :username,
        password = PASSWORD(:password),
        first_name = :first_name,
        last_name = :last_name,
        birthday = :birthday,
        email = :email,
        gender = :gender';


        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->birthday = htmlspecialchars(strip_tags($this->birthday));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->gender = htmlspecialchars(strip_tags($this->gender));


        //bind data
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':birthday', $this->birthday);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':gender', $this->gender);

        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;
    }

    //update email
    public function updateEmail(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;
        //create query
        $query= 'update ' .$this->table . ' set email = :email where id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        //bind data
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id);

        //execute query
        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;

    }

    //update username
    //nu merge
    public function updateUsername($username){
        $database = new Database();
        $db = $database->connect();
        $this->conn = $db;
        //check if username is taken
        if($this->checkUsername($username)===0){
            //create query
            $query= 'update ' .$this->table . ' set username = :username where id = :id';
            print_r("am ajuns");
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->password = htmlspecialchars(strip_tags($this->username));
            $this->id = htmlspecialchars(strip_tags($this->id));
            //bind data
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':id', $this->id);

            //execute query
            if($stmt->execute()){
                return true;
            }else{
                //print error if something goes wrong in execute
                printf('Error: %s.\n', $stmt->err);
            }
        }
        else
            return false;
    }


    //update user
    public function update(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;
        //create query
        $query='update ' . $this->table . ' set 
        username = :username,
        password = PASSWORD(:password),
        first_name = :first_name,
        last_name = :last_name,
        birthday = :birthday,
        email = :email,
        gender = :gender
        where  id=:id';


        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->birthday = htmlspecialchars(strip_tags($this->birthday));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind data
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':birthday', $this->birthday);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':id', $this->id);

        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;
    }

    public function updatePassword(){
        $database = new Database();
        $db = $database->connect();
        $this->conn =$db;
        //create query
        $query= 'update ' .$this->table . ' set password = PASSWORD(:password) where id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //bind data
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':id', $this->id);

        //execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong in execute
        printf('Error: %s.\n', $stmt->err);

        return false;
    }


    //delete user
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

    //returns false if username does exist in DB,
    //true, otherwise
    public function checkUsername($username){
        $database = new Database();
        $db = $database->connect();
        $this->conn = $db;

        $query = 'SELECT * FROM users where username=?';

        $stmt = $this->conn->prepare($query);

        //clean data
        $this->username = htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(1, $this->username);

        $stmt->execute();
        //execute query
        return $stmt->rowCount();
        // if($stmt->rowCount()>0){
        //     return false;
        // }
        // else{
        //     return true;
        // }
        //print error if something goes wrong in execute
        //printf('Error: %s.\n', $stmt->err);
        //return false;

    }

    //search stuff



}