<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="BookPage.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="navbar.css">
    <link rel="stylesheet" type="text/css" href="navbar700.css">
    <!-- libraria pentru icon-urile de la meniu: font-awesome.min.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>TITLUL PAGINII</title>
</head>
<body>
    <div class="bookpage">
        <div class="navbar">
            <a class="#" href="#"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="#" href="#"><i class="fa fa-newspaper-o"></i> Reviews</a>
            <a class="#" href="#"><i class="fa fa-fw fa-book"></i> Fresh off the shelves</a>
            <a class="#" href="#"><i class="fa fa-fw fa-envelope"></i> Contact</a>
            <a class="#" href="#"><i class="fa fa-fw fa-user"></i> Login</a>
            <a class="active" href="signUp.html"><i class="fa fa-user-plus" ></i> Sign Up</a>
        </div>
        
        <img src="book.jpg" alt="Book">
        
        <div class="info">
            <h1> Titlu cartii </h1> 
            <h2> Autor: Nume Autor </h2>  
            <h2> Editura: editura </h2>  
            <div class="rating">
                <h2> Rating: </h2> 
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <button class="Button">Submit</button>
            </div>         
        </div>
    </div>


    <div class="comments">
        <h2> Comentarii </h2>
        <strong> Comentator </strong>
        <input type="text">
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
    </div>

    <div class="company">
        <p> <strong> COMPANY </strong> </p>
        <p>About us</p>
        <p>Careers</p>
        <p>Terms</p>
        <p>Privacy</p>
        <p>Help</p>
    </div>

    <div class="WorkWithUs">
        <p> <strong> Work With Us </strong> </p>
        <p>Authors</p>
        <p>Adventise</p>
        <p>Authors & ads blog</p>
        <p>API</p>
    </div>

    <div class="made">
        <p> <strong> Made </strong> </p>
        <p>Made is 2020</p>
        <p>Boghiu Georgiana</p>
        <p>Vasilescu Andrei</p>
        <p>Taga Stefan Razvan</p>
    </div>

    <br>
    <button class="LogOut">Log Out</button>

</body>
</html>