<?php

//headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../config/Database.php'; #aducem baza de date
include_once '../../models/Book.php'; #aducem modelele necesare

//Instatiem BD & connect

$database = new Database();
$db = $database->connect();

//instantiem cartea
$book=new Book($db);

//books query
$result = $book->getBooks();
//get row count
$num = $result->rowCount();

//vf daca sunt useri
if($num>0){
    //users array
    $books_arr=array(); #date in format json
    $books_arr['data']=array(); #datele din json, fara formatul json

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row); 
        # in loc sa folosim $row['username'], extract va scoate variabilele
        #si le vom putea folosi ca $username

        $book_item = array(
            'id' => $id,
            'author_id' => $author_id,
            'publHouse_id' => $publHouse_id,
            'year' => $year,
            'body' => $body,
            'title' => $title,
            'posting_date' => $posting_date
        );

        //push to 'data'
        array_push($books_arr['data'], $book_item);
    
    }
    //turn to json
    echo json_encode($books_arr);
}else{
    //no users
    echo json_encode(
        array('message'=> 'No books found')
    );

}