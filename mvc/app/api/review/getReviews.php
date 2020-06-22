<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Review.php'; #aducem modelele necesare

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem cartea
$review=new Review($db);

//books query
$result = $review->getReviews();
//get row count
$num = $result->rowCount();

//vf daca sunt useri
if($num>0){
    //users array
    $reviews_arr=array(); #date in format json
    $reviews_arr['data']=array(); #datele din json, fara formatul json

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row); 
        # in loc sa folosim $row['username'], extract va scoate variabilele
        #si le vom putea folosi ca $username

        $review_item = array(
            'id' => $id,
            'user_id' => $user_id,
            'book_id' => $book_id,
            'body' => $body,
            'title' => $title,
            'posting_date' => $posting_date
        );

        //push to 'data'
        array_push($reviews_arr['data'], $review_item);
    
    }
    //turn to json
    echo json_encode($reviews_arr);
}else{
    //no users
    echo json_encode(
        array('message'=> 'No reviews found')
    );

}