<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../models/User.php'; #aducem modelele necesare
/*{
    "username" : "miau",
    "password" : "miau",
    "email" : "maieu@gogu.com",
    "last_name" : "miaunel",
    "first_name" : "balanel",
    "birthday" : "2019-01-20",
    "gender" : "M"
  } */

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$user = new User($data->username, $data->password, $data->first_name, $data->last_name,
                $data->email, $data->birthday, $data->gender);
if($user->checkUsername($data->username))
    //create user
    if($user->create()) {
        echo json_encode(
            array('message' => 'User Created')
        );
    }
    else {
        echo json_encode(
            array('message' => 'User Not Created')
        );
    }
else{
    echo json_encode(
        array('message' => 'Username already exists')
    );
}

