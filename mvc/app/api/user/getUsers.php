<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/User.php'; #aducem modelele necesare


 $user=new User(null,null,null,null,null,null,null);

//users query
$result = $user->getUsers();
//get row count
$num = $result->rowCount();

//vf daca sunt useri
if($num>0){
    //users array
    $users_arr=array(); #date in format json
    $users_arr['data']=array(); #datele din json, fara formatul json

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
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
    echo json_encode($users_arr);
}else{
    //no users
    echo json_encode(
        array('message'=> 'No users found')
    );

}