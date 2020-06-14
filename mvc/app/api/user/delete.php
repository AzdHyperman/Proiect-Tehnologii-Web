<?php
//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/User.php'; #aducem modelele necesare



//instantiem userii
$user = new User(null,null,null,null,null,null,null);

//get raw posted data
//$data = json_decode(file_get_contents("php://input"));
$user->id = isset($_GET['id'])? $_GET['id']:die();

if($user->getUser())
    //delete user
    if($user->delete()) {
        echo json_encode(
            array('message' => 'User Deleted')
        );
    }
    else {
        echo json_encode(
            array('message' => 'User Not Deleted')
        );
    }
else{
    echo json_encode(
        array('message' => 'User Does Not Exist')
    );
}

