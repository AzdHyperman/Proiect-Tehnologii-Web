<?php
// echo "<!DOCTYPE html>
// <html lang=\"en\">";
//session_start();
require_once (__DIR__."/../controllers/BookController.php");
//print_r($_GET);
//print_r($_SESSION);
// if(isset($_GET['books'])){
    if(isset($_SESSION['LOGINstatus']) && $_SESSION['LOGINstatus']==="false" ){
        $bookController = new BookController();
        $data = json_decode($bookController->all());
        //print_r($data);
        $books = $data->data;
        //print_r($data);
        foreach($books as $book){
           echo "<br><div class='articlePreview'>";
           echo "<a href='#'>";
           echo "<img src='../images/Books-icon.png' alt='" . $book->title . "' > <br>";
           echo "<h4>" . $book->title . "</h4>";
           echo "<h5>by " . $book->author_id . "</h5>";
           echo "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
               Porro officiis alias, vero vel explicabo possimus voluptatibus 
               reprehenderit suscipit earum exercitationem nemo mollitia. Optio 
               cupiditate cumque quia amet nihil, tempora ipsum.
           </p>";
           echo "<h5>review by Username</h5>";
           echo "</a>
       </div>";
       }
    }
    //print_r('sal');

?>