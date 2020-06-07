<!DOCTYPE html>
<?php header("Content-Type: html");?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" type="text/css" href="../public/styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/navbar700.css">
    <!-- libraria pentru icon-urile de la meniu: font-awesome.min.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/reviews.css">
    <link rel="stylesheet" type="text/css" href="../public/styles/reviews400.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a class="#" href="home.html"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="active" href="reviews.html"><i class="fa fa-newspaper-o"></i> Reviews</a>
            <a class="#" href="freshOffTheShelves.html"><i class="fa fa-fw fa-book"></i> Fresh off the shelves</a>
            <a class="#" href="#"><i class="fa fa-fw fa-user"></i> Login</a>
            <a class="#" href="signUp.html"><i class="fa fa-user-plus" ></i> Sign Up</a>
        </div>
    </header>

    <main>

        <label for="search" ></label>
        <input id="search" type="text" placeholder="Search" name="search">

        <div>
        <label id="organizer"> Order by </label>

        <label for="category">Category</label>
        <select id="category">
        <?php
            // foreach($data["genres"] as $genre){
            //     echo "<option value=\"".$genre->name."\">".$genre->name."</option>";
            // }
            ?>
        </select>

        <label for="author">Author</label>
        <select id="author">
            <!-- <option value="all">-</option>
            <option value="Emil Garleanu">Emil Garleanu</option>
            <option value="Irina Binder">Irina Binder</option>
            <option value="J.K.Rowling">J.K. Rowling</option>
            <option value="Nora Roberts">Nora Roberts</option>
            <option value="Alexander Pushkin">Alexander Pushkin</option>
            <option value="Agatha Christie">Agatha Christie</option>
            <option value="Stephen King">Stephen King</option> -->
            <?php
            print_r($data->authors);
            foreach($data->authors as $author){
                echo "<option value=\"".$author->name."\">" . $author->name . "</option>";
            }
            ?>
        </select>

        <label for="publishedBy">Published by</label>
        <select id="publichedBy">
        <?php
        $html="";
            foreach($data->publishingHouses as $ph){
                $html=$html."<option value=\"".$ph->name."\">".$ph->name."</option>";
            }
            echo $html;
            ?>
        </select>

        <label for="year">Year</label>
        <select id="year">
            <option value="all">-</option>
            <option value="1990">1990</option>
            <option value="1995">1995</option>
            <option value="1998">1998</option>
            <option value="2000">2000</option>
            <option value="2006">2006</option>
            <option value="2007">2007</option>
            <option value="2008">2008</option>
            <option value="2012">2012</option>
            
        </select>

        <label for="reviewedBy">Reviewed by user:</label>
        <input id="reviewedBy" type="text">
        </div>


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

        <div class="articleContainer">
            <div class="articlePreview">
                <img alt="book image" src="../images/Books-icon.png" >
                <header>
                    <h2><a href="#">Titlu</a></h2>
                    <h4>by Name of the author</h4>
                </header>
                <p>Lorem ipsum dolor sit amet consectetur, 
                    adipisicing elit.Culpa, accusamus quo officiis harum 
                    suscipit, accusantium obcaecati corrupti repellat aspernatur 
                    laudantium, illo aperiam repellendus nostrum provident rem vitae quasi odio quibusdam.
                </p>
                <footer>Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    <h4>reviewed by Username</h4>
                </footer>

            </div>
            <div class="articlePreview">
                <img alt="book image" src="../images/Books-icon.png" >
                <header>
                    <h2><a href="#">Titlu</a></h2>
                    <h4>by Name of the author</h4>
                </header>
                <p>Lorem ipsum dolor sit amet consectetur, 
                    adipisicing elit.Culpa, accusamus quo officiis harum 
                    suscipit, accusantium obcaecati corrupti repellat aspernatur 
                    laudantium, illo aperiam repellendus nostrum provident rem vitae quasi odio quibusdam.
                </p>
                <footer>Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    <h4>reviewed by Username</h4>
                </footer>

            </div>
            <div class="articlePreview">
                <img alt="book image" src="../images/Books-icon.png" >
                <header>
                    <h2><a href="#">Titlu</a></h2>
                    <h4>by Name of the author</h4>
                </header>
                <p>Lorem ipsum dolor sit amet consectetur, 
                    adipisicing elit.Culpa, accusamus quo officiis harum 
                    suscipit, accusantium obcaecati corrupti repellat aspernatur 
                    laudantium, illo aperiam repellendus nostrum provident rem vitae quasi odio quibusdam.
                </p>
                <footer>Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    <h4>reviewed by Username</h4>
                </footer>

            </div><div class="articlePreview">
                <img alt="book image" src="../images/Books-icon.png" >
                <header>
                    <h2><a href="#">Titlu</a></h2>
                    <h4>by Name of the author</h4>
                </header>
                <p>Lorem ipsum dolor sit amet consectetur, 
                    adipisicing elit.Culpa, accusamus quo officiis harum 
                    suscipit, accusantium obcaecati corrupti repellat aspernatur 
                    laudantium, illo aperiam repellendus nostrum provident rem vitae quasi odio quibusdam.
                </p>
                <footer>Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    <h4>reviewed by Username</h4>
                </footer>

            </div>
            <div class="articlePreview">
                <img alt="book image" src="../images/Books-icon.png">
                <header>
                    <h2><a href="#">Titlu</a></h2>
                    <h4>by Name of the author</h4>
                </header>
                <p>Lorem ipsum dolor sit amet consectetur, 
                    adipisicing elit.Culpa, accusamus quo officiis harum 
                    suscipit, accusantium obcaecati corrupti repellat aspernatur 
                    laudantium, illo aperiam repellendus nostrum provident rem vitae quasi odio quibusdam.
                </p>
                <footer>Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    <h4>reviewed by Username</h4>
                </footer>

            </div>
            <div class="articlePreview">
                <img alt="book image" src="../images/Books-icon.png">
                <header>
                    <h2><a href="#">Titlu</a></h2>
                    <h4>by Name of the author</h4>
                </header>
                <p>Lorem ipsum dolor sit amet consectetur, 
                    adipisicing elit.Culpa, accusamus quo officiis harum 
                    suscipit, accusantium obcaecati corrupti repellat aspernatur 
                    laudantium, illo aperiam repellendus nostrum provident rem vitae quasi odio quibusdam.
                </p>
                <footer>Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    <h4>reviewed by Username</h4>
                </footer>

            </div>
            <div class="articlePreview">
                <img alt="book image" src="../images/Books-icon.png">
                <header>
                    <h2><a href="#">Titlu</a></h2>
                    <h4>by Name of the author</h4>
                </header>
                <p>Lorem ipsum dolor sit amet consectetur, 
                    adipisicing elit.Culpa, accusamus quo officiis harum 
                    suscipit, accusantium obcaecati corrupti repellat aspernatur 
                    laudantium, illo aperiam repellendus nostrum provident rem vitae quasi odio quibusdam.
                </p>
                <footer>Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    <h4>reviewed by Username</h4>
                </footer>

            </div>
            <div class="articlePreview">
                <img alt="book image" src="../images/Books-icon.png">
                <header>
                    <h2><a href="#">Titlu</a></h2>
                    <h4>by Name of the author</h4>
                </header>
                <p>Lorem ipsum dolor sit amet consectetur, 
                    adipisicing elit.Culpa, accusamus quo officiis harum 
                    suscipit, accusantium obcaecati corrupti repellat aspernatur 
                    laudantium, illo aperiam repellendus nostrum provident rem vitae quasi odio quibusdam.
                </p>
                <footer>Rating
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    <h4>reviewed by Username</h4>
                </footer>

            </div>

        </div>
    </main>

</body>
</html>