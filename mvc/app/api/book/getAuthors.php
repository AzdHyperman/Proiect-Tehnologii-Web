<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Author.php'; #aducem modelele necesare

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem userii
$author=new Author($db);

//users query
$result = $author->getAuthors();
//get row count
$num = $result->rowCount();

//vf daca sunt useri
if($num>0){
    //users array
    $authors_arr=array(); #date in format json
    $authors_arr['data']=array(); #datele din json, fara formatul json

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row); 
        # in loc sa folosim $row['username'], extract va scoate variabilele
        #si le vom putea folosi ca $username

        $author_item = array(
            'id'=> $id,
            'name' => $name
        );

        //push to 'data'
        array_push($authors_arr['data'], $author_item);
    
    }
    //turn to json
    echo json_encode($authors_arr);
}else{
    //no users
    echo json_encode(
        array('message'=> 'No authors found')
    );

}