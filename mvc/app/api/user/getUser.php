<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/User.php'; #aducem modelele necesare


//instantiem userul
$user=new User(null,null,null,null,null,null,null);
//something.com?id=3 luam 3 din url
//get ID 
$user->id = isset($_GET['id'])? $_GET['id']:die();

//get user
$user->getUser();
if($user->username !== null){
//create array
$user_arr=array(
    'id' => $user->id,
    'username' => $user->username,
    'password' => $user->password,
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
    'email' => $user->email,
    'birthday' => $user->birthday,
    'gender' => $user->gender
);

//make json
print_r(json_encode($user_arr));
}
else{
    echo json_encode(
        array('message'=> 'User does not exist')
    );
}