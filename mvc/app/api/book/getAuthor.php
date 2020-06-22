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
$author = new Author($db);
//something.com?id=3 luam 3 din url
//get name or id
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

//get user
$author->getAuthor();

//create array
$author_arr=array(
    'id' => $author->id,
    'name' => $author->name
);

//make json
print_r(json_encode($author_arr));
