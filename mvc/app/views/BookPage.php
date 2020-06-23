<?php header("Content-Type: html"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../public/styles/BookPage.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/navbar700.css">
    <!-- libraria pentru icon-urile de la meniu: font-awesome.min.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title><?php echo $data[0]->title; ?></title>
</head>
<body>
    <div class="bookpage">
        <div class="navbar">
        <a class="#" href="../../home.php"><i class="fa fa-fw fa-home"></i> Home</a>
        <a class="#" href="../../reviews.php"><i class="fa fa-newspaper-o"></i> Reviews</a>
        <a class="active" href="../../freshOffTheShelves.html"><i class="fa fa-fw fa-book"></i> Fresh off the shelves</a>
        <a class="#" href="../../LogIn.html"><i class="fa fa-fw fa-user"></i> Login</a>
        <a class="#" href="../../signUp.php"><i class="fa fa-user-plus" ></i> Sign Up</a>
        </div>
        <br>
    <button class="LogOut">Log Out</button>
        <img src="book.jpg" alt="Book">
        
        <div class="info">
            <?php 
            $html="";
            $html=$html."<h1>". $data[0]->title." </h1>"; 
            $html=$html."<h2> Autor:" .$data[0]->author->name." </h2>";
            $html=$html."<h2> Editura:" . $data[0]->publHouse->name. "</h2>";  
            $html=$html."<div class=\"rating\">";
            $html=$html."    <h2> Rating:".$data[0]->rating." </h2> ";
            $html=$html."    <button class=\"Button\">Submit</button> </div> </div> </div>";
            echo $html;
            ?>

    <div class="comments">
        <h2> Comentarii </h2>
        <strong> Comentator </strong>
        <input type="text">
        <?php
            $users_arr = $data[0]->comments;
        
            foreach($users_arr as $users){
                echo "<ul>";
                echo "<br>";
                echo $users->user->username;
                echo "<br>";
                echo $users->body;
                echo "<br>";
                echo $users->posted_at;
                echo "</ul>";
                echo "<br>";
            }
            echo "<br>";
        ?>
    </div>

    <div class="footer">
    <ul class="between">
    <li><h3>Company</h3>
    <p>About us</p>
    <p>Careers</p>
    <p>Terms</p>
    <p>Privacy</p>
    <p>Help</p>
    </li>
    <li><h3>Contact Us</h3>
      <p>Facebook</p>
      <p>Instagram</p>
      <p>Contact</p>
    </li>
    <li><h3>Made by</h3>
      <p>Boghiu Georgiana Viorica</p>
      <p>Taga Stefan Razvan</p>
      <p>Vasilescu Andrei</p>
    </li>
    
  </ul>
  <p class="Copyright">BookReviewer.net(not online yet) is a property of BookReviewer, LLC. ©2020 All Rights Reserved.</p>
  
</div>

    

</body>
</html>