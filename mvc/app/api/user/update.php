<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/User.php'; #aducem modelele necesare
/*
{
  	"id": "4",
	"username": "jojo20",
	"password": "miaunel",
	"last_name" : "Bobitx",
	"first_name" : "Geo",
	"email": "jojo20202@gmail.com",
	"birthday": "1998-05-20",
	"gender": "F"
}
*/


//instantiem userii
$user = new User(null,null,null,null,null,null,null);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//set ID to update
$user->id = $data->id;
//daca userul exista il updatam
if($user->getUser()){
    $user->username = $data->username;
    $user->password = $data->password;
    $user->first_name = $data->first_name;
    $user->last_name = $data->last_name;
    $user->birthday = $data->birthday;
    $user->email = $data->email;
    $user->gender = $data->gender;

    //update user
    if($user->update()) {
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

