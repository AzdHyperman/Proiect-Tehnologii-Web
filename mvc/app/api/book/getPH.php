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
$ph = new publishingHouse($db);
//something.com?id=3 luam 3 din url
//get name or id
$ph->id = isset($_GET['id']) ? $_GET['id'] : die();

//get user
$ph->getPublishingHouse();

//create array
$ph_arr=array(
    'id' => $ph->id,
    'name' => $ph->name,
    'country' => $ph->country,
    'founded' => $ph->founded
);

//make json
print_r(json_encode($ph_arr));
