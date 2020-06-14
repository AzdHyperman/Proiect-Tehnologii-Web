<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/publishingHouse.php'; #aducem modelele necesare

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem userii
$ph=new publishingHouse($db);

//users query
$result = $ph->getPublishingHouses();
//get row count
$num = $result->rowCount();

//vf daca sunt useri
if($num>0){
    //users array
    $phs_arr = array(); #date in format json
    $phs_arr['data'] = array(); #datele din json, fara formatul json

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row); 
        # in loc sa folosim $row['username'], extract va scoate variabilele
        #si le vom putea folosi ca $username

        $ph_item = array(
            'id'=> $id,
            'name' => $name,
            'country' => $country,
            'founded' => $founded
        );

        //push to 'data'
        array_push($phs_arr['data'], $ph_item);
    
    }
    //turn to json
    echo json_encode($phs_arr);
}else{
    //no users
    echo json_encode(
        array('message'=> 'No Publishing Houses found')
    );

}