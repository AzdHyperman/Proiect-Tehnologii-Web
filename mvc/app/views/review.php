<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../../public/styles/Review.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../public/styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="../../public/styles/navbar700.css">
    <!-- libraria pentru icon-urile de la meniu: font-awesome.min.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Review</title>
</head>

<body>
    <div class="navbar">
            <a class="#" href="home"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="active" href="reviews"><i class="fa fa-newspaper-o"></i> Reviews</a>
            <a class="#" href="freshOffTheShelves.html"><i class="fa fa-fw fa-book"></i> Fresh off the shelves</a>
            <a class="#" href="LogIn.html"><i class="fa fa-fw fa-user"></i> Login</a>
            <a class="#" href="signUp"><i class="fa fa-user-plus" ></i> Sign Up</a>
    </div>
        
    <div>
        <img src="profile.jpg" alt="Profile">
        <h3>NumeComentator</h3>
        <div class="rating">
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star"></span>
            <span class="fa fa-star"></span>    
        </div>
        <div class="account">
            <input type="text">
        </div>
        <Button class="Confirm"> Confirm </Button>
    </div>

    <?php
        $user1=array("nume"=>"nume1","body"=>"comentez si eu1","data"=>"2020-05-01");
        $user2=array("nume"=>"nume2","body"=>"comentez si eu2","data"=>"2020-05-01");
        $user3=array("nume"=>"nume3","body"=>"comentez si eu3","data"=>"2020-05-01");
        
        $users_arr=array(); 
        array_push($users_arr,$user1);
        array_push($users_arr,$user2);
        array_push($users_arr,$user3);
        
        foreach($users_arr as $users){
            echo "<ul>";
            echo "<br>";
            echo "<img src='profile.jpg' alt= 'Profile'>";
            echo $users["nume"];
            echo "<br>";
            echo $users["body"];
            echo "<br>";
            echo $users["data"];
            echo "<div> <span class= 'fa fa-star checked'> </span> 
                <span class= 'fa fa-star checked'> </span>
                <span class= 'fa fa-star checked'> </span>
                <span class= 'fa fa-star'> </span>
                <span class= 'fa fa-star'> </span>
                </div>";
            echo "</ul>";
            echo "<br>";
        }
        echo "<br>";
    ?>

    <div class="pagination"> 
        <a href="#">&laquo;</a>
        <a class="active" href="#">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">&raquo;</a>
    </div>

</body>
