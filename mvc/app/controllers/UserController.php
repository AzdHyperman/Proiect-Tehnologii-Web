<?php
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

require_once(__DIR__ . '\..\core\Controller.php');
require_once(__DIR__ . '\..\models\User.php');

class UserController extends Controller{
    public $conn;
    public $table = 'users';
    public $user;
    //initializez si invoc(=apelez met care trebe) modelul, 

    public function __construct(){}

    public function setUser($name,$pass,$fname,$lname,$email,$date,$gender){
        $this->user = new User($name,$pass,$fname,$lname,$email,$date,$gender);
    }

    public function new(){
        try{
            $this->user->create();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return;
        }
            
    }
    
    public function index(){
        echo 'hello from user controller.'; 
    }

    //GET
    public function getUsers(){
        try{
            if($this->user === null){
                $this->user = new User(null,null,null,null,null,null,null);
            }
            echo $this->user->getUsers();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return;
        }   
    }

    //GET cum sa iau ceva?id=3
    //apelez /UserController/getUser/<id>
    public function getUser($id){
        if($this->user === null){
            $this->setUser(null,null,null,null,null,null,null);
        }
        $this->user->id = $id;//isset($_GET['id'])? $_GET['id']:die();

        //get user
        $this->user->getUser();
        if($this->user->username !== null){

        $user_arr = array($this->user);

        //make json
        print_r(json_encode($user_arr)); //return cv?
        }
        else{
            echo json_encode(
                array('message'=> 'User does not exist')
            ); //return din nou?
        }
    }

    //PUT
    // {
    //     "id" : "3",
    //     "email" : "miau@yahoo.com"
    //   }
    public function updateEmail(){
        //get raw posted data from json
        $data = json_decode(file_get_contents("php://input"));
        //init user if null
        if($this->user === null){
            $this->setUser(null,null,null,null,null,null,null);
        }
        $this->user->id = $data->id;
        //check if user exists and change email ,else print message
        if($this->user->getUser()){
            $this->user->email = $data->email;
            //update user
            if($this->user->updateEmail()) {
                echo json_encode(
                    array('message' => 'Email Updated')
                );
            }
            else {
                echo json_encode(
                    array('message' => 'Email Not Updated')
                );
            }
        }
        else {
            echo json_encode(
                array('message' => 'User does not exist')
            );
        }
    }


    //PUT
    // {
    //     "id" : "3",
    //     "old_password" : "ceva239483",
    //     "new_password" : "jojo20202"
    //   }
    public function updatePassword(){
        $data = json_decode(file_get_contents("php://input"));

        if($this->user === null){
            $this->setUser(null,null,null,null,null,null,null);
        }
        $this->user->id = $data->id;

        if($this->user->getUser())
        {
            if($this->user->password === $data->old_password)
            {
                $this->user->password = $data->new_password;

                //update password
                if($this->user->updatePassword()) {
                    echo json_encode(
                        array('message' => 'Password Updated')
                    );
                }
                else {
                    echo json_encode(
                        array('message' => 'Password Not Updated')
                    );
                }
            }
            else {
                echo json_encode(
                    array('message' => 'Old Password is not correct')
                );
            }
        }
        else{
            echo json_encode(
                array('message' => 'User does not exist')
            );
        }
    }

    //PUT
    // {
    //     "username" : "ceva",
    //     "password" : "ceva",
    //     "first_name" : "ceva",
    //     "last_name" : "ceva",
    //     "birthday" : "1999-02-20",
    //     "email" : "ceva@ceva.com",
    //     "gender" : "F"
    // }
    public function update(){
        $data = json_decode(file_get_contents("php://input"));

        if($this->user === null){
            $this->setUser(null,null,null,null,null,null,null);
        }
        //set ID to update
        $this->user->id = $data->id;
        //daca userul exista il updatam
        if($this->user->getUser()){
            $this->user->username = $data->username;
            $this->user->password = $data->password;
            $this->user->first_name = $data->first_name;
            $this->user->last_name = $data->last_name;
            $this->user->birthday = $data->birthday;
            $this->user->email = $data->email;
            $this->user->gender = $data->gender;

            //update user
            if($this->user->update()) {
                echo json_encode(
                    array('message' => 'User Updated')
                );
            }
            else {
                echo json_encode(
                    array('message' => 'User Not Updated')
                );
            }
        }
        else {
            echo json_encode(
                array('message' => 'User does not exist')
            );
        }

    }

    //vf datele primite daca sunt null, de facut si in user.
    //nu e gata, l-oi termina alta data
    public function patch(){
        $data = json_decode(file_get_contents("php://input"));

        if($this->user === null){
            $this->setUser(null,null,null,null,null,null,null);
        }

        $this->user->id = $data->id;
        if($this->user->getUser())
        {   
            //print_r($this->user);
            if(isset($data->username)){
                if($this->user->updateUsername($data->username))
                    echo json_encode(
                        array('message' => 'Username Updated')
                    );
                else
                    echo json_encode(
                        array('message' => 'Username not Updated')
                    );
            }
        }
        else
            echo json_encode(
                array('message' => 'User does not exist')
            );
    }

    //.../UserController/delete/<id>
    public function delete($id){
        if($this->user === null){
            $this->setUser(null,null,null,null,null,null,null);
        }
        $this->user->id = $id;
        if($this->user->getUser()){
            if($this->user->delete()){
                echo json_encode(
                    array('message' => 'User Deleted')
                );
            }
            else{
                    echo json_encode(
                        array('message' => 'User Not Deleted')
                    );
            }
                
        }
        else
        echo json_encode(
            array('message' => 'User does not exist')
        );
    }



}