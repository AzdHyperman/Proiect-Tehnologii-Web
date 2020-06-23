
<html>
<?php header("Content-Type: html"); 
include_once __DIR__."/../controllers/BookController.php";

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Reviewer</title>
    <link rel="stylesheet" type="text/css" href="../public/styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/navbar700.css">
    <!-- libraria pentru icon-urile de la meniu: font-awesome.min.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/reviews.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/reviews400.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/home_user.css">

</head>
<body>
    <header>
        <div class="navbar">
            <a class="active" href="home"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="#" href="reviews"><i class="fa fa-newspaper-o"></i> Reviews</a>
            <a class="#" href="freshOffTheShelves.html"><i class="fa fa-fw fa-book"></i> Fresh off the shelves</a>
            <a class="#" href="home"><i class="fa fa-fw fa-user"></i> Login</a>
            <a class="#" href="signUp"><i class="fa fa-user-plus" ></i> Sign Up</a>
        </div>
    </header>

    <h2>Start your book-journey with us! </h2>
    <main>
        <h3>Here's what's new </h3>
        <div class="articleContainer">
        <?php
            if(isset($_SESSION['LOGINstatus']) && $_SESSION['LOGINstatus']==="false" ){
               //print_r($data);
                $books = $data;
                $html="";
                foreach($books as $book){
                    $html = $html . "<br><div class='articlePreview'>";
                    $html = $html . "<a href='BookController/item/".$book['id']."'>";
                    $html = $html . "<img src='" . __DIR__ . "/../../public/images/Books-icon.png' alt='" . $book['title'] . "' > <br>";
                    $html = $html . "<h4>" . $book['title'] . "</h4>";
                    $html = $html . "<h5>by " . $book['author_id']->name . "</h5>";
                    $html = $html . "<p>".$book['body']."</p>";
                   //$html = $html . "<h5>review by Username</h5>";
                    $html = $html . "</a> </div>";
                }
                echo $html;
            }
        ?>
        </div>

    </main>
</body>
</html>