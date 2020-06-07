<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/User.php'; #aducem modelele necesare
include_once '../../models/Comment.php';

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem userii
$comment = new Comment($db);

//users query
$result = $comment->getComments();
//get row count
$num = $result->rowCount();

//vf daca sunt useri
if($num>0){
    //users array
    $comms_arr = array(); #date in format json
    $comms_arr['data'] = array(); #datele din json, fara formatul json

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row); 
        # in loc sa folosim $row['username'], extract va scoate variabilele
        #si le vom putea folosi ca $username

        $user = new User($db);
        $user->id = $user_id;
        $user->getUser();
 

        $comment_item = array(
            'id'=>$id,
            'body' =>$body,
            'id_article' => $id_article,
            'type' => $type,
            'user' => $user,
            'posted_at' => $posted_at
        );

        //push to 'data'
        array_push($comms_arr['data'], $comment_item);
    
    }
    //turn to json
    echo json_encode($comms_arr);
}else{
    //no users
    echo json_encode(
        array('message'=> 'No Comments Found')
    );

}