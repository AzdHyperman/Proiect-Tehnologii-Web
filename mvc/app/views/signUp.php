<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="../public/styles/signUp.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/signUp700.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/buttons.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/general.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/general700.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/navbar700.css">

    <!-- libraria pentru icon-urile de la meniu: font-awesome.min.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

    <header>
    <div class="navbar">
        <a class="#" href="home.html"><i class="fa fa-fw fa-home"></i> Home</a>
        <a class="#" href="reviews.html"><i class="fa fa-newspaper-o"></i> Reviews</a>
        <a class="#" href="#"><i class="fa fa-fw fa-book"></i> Fresh off the shelves</a>
        <a class="#" href="#"><i class="fa fa-fw fa-user"></i> Login</a>
        <a class="active" href="signUp.html"><i class="fa fa-user-plus" ></i> Sign Up</a>
    </div>
    </header>
    
    <main>
    <h1 class="title">Sign Up</h1>
    <h2 class="subtitle">and let the adventure begin!</h2>
    <form class="signUpForm" method="POST" action="../app/routes/signUp.php">
        <div>
            <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Choose your username" required>
        </div>
        <div>
            <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="First name" required>
        </div>
        <div>
            <label for="lastName">Last Name</label>
                <input  type="text" id="lastName" name="lastName" placeholder="Last name" required>
        </div>
        <div>
            <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
        </div>
        <div>
            <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <div>
           <label for="birthday">Birthday</label><br> 
                <input type="date" name="birthday" required>
        
        </div>
        <div>
            <label for="gender">Gender</label><br>
                <input type="radio" id="male" name="gender" value="male">
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female">
                <label for="female">Female</label>
                <input type="radio" id="other" name="gender" value="other">
                <label for="other">Other</label>
            
        </div>
        <div>
        <input class="animatedLine1 button5" type="submit" id="user_sign" name="user_sign" value="Sign Up">
        </div>      
    </form>
</main>
</body>
</html>