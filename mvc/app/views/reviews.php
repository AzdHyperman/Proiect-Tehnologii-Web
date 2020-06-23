
<!DOCTYPE html>
<?php header("Content-Type: html"); 
require_once (__DIR__."/../controllers/ReviewController.php");
require_once (__DIR__."/../models/Book.php");
$contr = new ReviewController();
$data2=$data;
if(!isset($data['authors']) || !isset($data['publishingHouses']))
    $data = $contr->prepPage();
if(isset($data2['reviews']) && $data2['reviews'] !== null){
    $data['reviews']=null;
    $data['reviews']=$data2['reviews'];
}
?>
    
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/bookreviewer/mvc/public/styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/bookreviewer/mvc/public/styles/navbar700.css">
    <!-- libraria pentru icon-urile de la meniu: font-awesome.min.css  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/bookreviewer/mvc/public/styles/reviews.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/reviews400.css">
    
</head>
<body>
    <header>
        <div class="navbar">
            <a class="#" href="home"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="active" href="reviews"><i class="fa fa-newspaper-o"></i> Reviews</a>
            <a class="#" href="freshOffTheShelves.html"><i class="fa fa-fw fa-book"></i> Fresh off the shelves</a>
            <a class="#" href="LogIn.html"><i class="fa fa-fw fa-user"></i> Login</a>
            <a class="#" href="signUp"><i class="fa fa-user-plus" ></i> Sign Up</a>
        </div>
    </header>

    <main>
        <header>
        
        <form method="GET" action="filter">
            <label> Filter by book </label><br>

            <label for="book_title">Title</label>
            <input id="book_title" name="book_title" type="text" placeholder="book title...">
            

            
            <label for="author">Author</label>
            <select id="author" name="author">
                <option></option>
                <?php
                for($i=0;$i<count($data['authors']);$i++){
                    echo "<option>" . $data['authors'][$i]['name'] . "</option>";
                }
                ?>
            </select>

            <label for="publishedBy">Published by</label>
            <select id="publishedBy" name="publishedBy">
                <option></option>
                <?php
                $html="";
                for($i=0;$i<count($data['publishingHouses']);$i++){
                        $html=$html."<option>".$data['publishingHouses'][$i]['name']."</option>";
                    }
                    echo $html;
                ?>
            </select>

            <label for="year">Year</label>
            <select id="year" name="year">
                <option ></option>
                <option value="1990">1990</option>
                <option value="1995">1995</option>
                <option value="1998">1998</option>
                <option value="2000">2000</option>
                <option value="2006">2006</option>
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2012">2012</option>
                
            </select>
            
            <br>
            <label for="reviewedBy"> Reviewed by </label>
            <input id="reviewedBy" name="reviewedBy" type="text" placeholder="username">

            <label for="title"> Title </label>
            <input id="title" name="title" type="text" placeholder="review title...">
            <input type="submit" id="find" name="find" value="Find">
            <!-- <button id="find"> Find </button> -->
            
        <div id="container" class="articleContainer">
            <?php 
            
                if($data['reviews'] !== null){
                    //print_r($data['reviews'][0][0]);
                    foreach($data['reviews'] as $review){
                        $book = new Book(null,null,null,null,null);
                        $str = "";
                        if($review['book_id'] > 0) {
                            $book->id = $review['book_id'];
                            $book->getBook();
                            $str = $book->title.' by '.$book->author->name;
                        }
                        else $str="Unknown book";

                        
                        echo '<div class="articlePreview">';
                        echo '<img alt="' . $review['title'] . ' image" src="../../public/images/Books-icon.png" >
                        <header>
                            <h2><a href="reviews/getReview/'.$review['id'].'">'.$review['title'].'</a></h2>
                            <h4>for ' . $str . '</h4>
                        </header>
                        <p>' . substr($review['body'],0,250).'...' . '</p>
                        <footer>Rating
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            <h4>reviewed by ' . $review['user_id']. '</h4>
                        </footer>
                    </div>';
                    }
                }
                else echo '<h2> No reviews found <h2>';
            ?>
        </div> 
        </form>

        <aside>
            <div class="asideTemplate">
            
                <label id="title">Most Popular</label>
            
                <div class="articlePreview">
                    <header><h3><a href="#">Title</a></h3></header>
                    <p>some little text max 250 characters</p>
                    <div id="rating">Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                </div>
                <div class="articlePreview">
                    <header><h3><a href="#">Title to fill the void</a></h3></header>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                        miaunel si balanel intr-un copacel
                    </p>
                    <div id="rating">Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                </div>
                <div class="articlePreview">
                    <header><h3><a href="#">Title</a></h3></header>
                    <p>some little text max 250 characters</p>
                    <div id="rating">Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                </div>
            </div>
        </aside>

    </main>

    <!-- <script src="../app/js/rev.js"></script> -->

</body>
</html>