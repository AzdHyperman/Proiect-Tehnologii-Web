<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/User.php'; #aducem modelele necesare

//instantiem userii
$user = new User(null,null,null,null,null,null,null);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//set ID to update
$user->id = $data->id;
if($user->getUser()){
    $user->email = $data->email;
    //update user
    if($user->updateEmail()) {
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


