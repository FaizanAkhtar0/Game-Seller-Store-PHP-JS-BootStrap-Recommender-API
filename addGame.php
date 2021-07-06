<?php
session_start();

if (empty($_SESSION['adminUsername'])) {
    echo '<script type="text/JavaScript">  
            location.href = \'/login.php\';
            </script>';
}

include "scripts/php/dbConnection.php";
@connectionStatus(); // '@' for hiding any warning shown on the body of page.

function makeQuery()
{
    include "scripts/php/insert.php";
    $title = addslashes($_POST['gameTitleField']);
    $gamePrice = ($_POST['price']);
    $category = addslashes($_POST['category']);
    $gameDate = date("D-M-Y", time()); // gets the day, date, month, year, time, AM or PM
    $gameDescription = addslashes($_POST['gameDescriptionField']);
    $imagefile = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
    $gamefile = $_FILES["game"]["name"];
    $target = "uploadedGames/" . basename($gamefile);

    $insertquery = "insert into games(game_name, category, date, description, price, file_name, image) values('$title','$category','$gameDate','$gameDescription','$gamePrice','$gamefile','$imagefile')";
    $con = mysqli_connect("localhost", "root", "", "db_motiongaming");
    if (mysqli_query($con, $insertquery)) {
        if (move_uploaded_file($_FILES['game']['tmp_name'], $target)) {
            echo '<script type="text/JavaScript">  
                alert("Your Game has been Uploaded!"); 
                </script>';
        } else {
            echo '<script type="text/JavaScript">  
                alert("Unable to upload game file!"); 
                </script>';
        }
    } else {
        echo '<script type="text/JavaScript">  
                alert("Unable to insert into Database!"); 
                </script>';
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/addGamesStyles.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Motion Gaming - Add Game</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-lg fixed-top">
        <a class="navbar-brand ml-50 p-2" href="adminIndex.php">
            <h2 class="brandIcon"><span style="font-weight:bolder">Motion</span> Gaming</h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Home
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="adminIndex.php">Home(Admin)</a>
                            <a class="dropdown-item" href="index.php" target="_blank">Home(User)</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Articles
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="createArticles.php">Create new articles</a>
                            <a class="dropdown-item" href="editArticles.php">Edit/Delete articles</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Games
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="addGame.php">Add new game</a>
                            <a class="dropdown-item" href="editGame.php">Edit/Delete games</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Games Reviews
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="approveReviews.php">Approve new reviews</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Users
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="manageUsers.php">Manage Users</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Orders
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="manageOrders.php">Manage Orders</a>
                        </div>
                    </div>
                </li>
                <div class="dropdown show bg-dark">
                    <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More
                    </a>
                    <div class="dropdown-menu" aria-labelledby="moreDropDown">
                        <a class="dropdown-item" href="#">Manage Gaming Softwares</a>
                        <a class="dropdown-item" href="#">Manage Boxed Games</a>
                        <a class="dropdown-item" href="#">Manage Product reviews</a>
                    </div>
                </div>
            </ul>

            <form class="form-inline my-2 my-lg-0">
                <div class="input-group mr-2">
                    <input type="search" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="SearchBar">
                    <div class="input-group-append">
                        <button class="btn btn-light" type="button"><span class="fa fa-search"></span></button>
                    </div>
                </div>
                <div class="dropdown show bg-dark ml-2 mr-5">
                    <?php
                    if (empty($_SESSION['adminUsername'])) {
                    ?>
                        <a role="button" href="login.php" class="btn btn-outline-light my-2 my-sm-0" type="submit">Login</a>
                    <?php
                    } else {
                    ?>
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="UserDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                        echo $_SESSION['adminUsername'];
                    }
                        ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="UserDropDown">
                            <a class="dropdown-item" href="manageProfile.php">Manage Profile</a>
                            <a class="dropdown-item" href="scripts/php/logout.php">Logout</a>
                        </div>
                </div>
            </form>
        </div>
    </nav>
    <br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1 col-sm-1 col-xs-1">
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
                <form class="formGame rounded" method="POST" enctype="multipart/form-data">
                    <div class="form-group inputBox">
                        <input class="form-control" type="text" name="gameTitleField" id="gameTitle" placeholder="Game Title" required autofocus>
                        <div class="dateInputBox">
                            <label for="gameCategory">Define a category:</label>
                            <input class="form-control" type="text" id="gameCategory" name="category" placeholder="Game category" required>
                            <label for="gamePrice">Game Price: $</label>
                            <input class="form-control" type="number" step="0.01" id="gamePrice" name="price" placeholder="Game Price" required>
                            <label for="gamePublishDate">Date: (Automated Insertion)</label>
                            <label for="imageField">Select Image: </label>
                            <input class="form-control" type="file" name="image" id="imageField" required>
                            <label for="gameField">Select Game File: </label>
                            <input class="form-control" type="file" name="game" id="gameField" required>
                        </div>
                        <div class="">
                            <textarea class="form-control" name="gameDescriptionField" id="gameDescription" rows="5" placeholder="Discription" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <button type="submit" name="submit" class="form-control btn btn-success btn-lg" id="addGame" onclick="verifyInsertionFields(gameTitle, gameCategory, gameField, imageField, gameDescription, gamePrice)">
                                    Add this game</button>
                                <div class="invisible">
                                    <input type="checkbox" name="uploadStatusField" id="uploadStatus" value="">
                                    <input type="hidden" name="uploadVal" id="upload">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['submit']) && ($_POST['uploadVal'] == '1')) {
                        makeQuery();
                    }
                    ?>
                </form>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
            </div>
        </div>
    </div>

    <footer class="footerStyle page-footer indigo pt-4">
                <div class="container-fluid text-center text-md-left">
                    <div class="row">
                        <div class="col-md-6 mt-md-0 mt-3">
                            <h5 class="">Organizational Moto</h5>
                            <p class="brandIcon" style="font-size: 2rem;">Life it self is a game. <br>And<br> "It is said that the ending of every game is decided at the very beginning of it's first step towards initiation".</p>
                        </div>
                        <hr class="clearfix w-100 d-md-none pb-3">
                        <div class="col-md-3 mb-md-0 mb-3">
                            <h5 class="text-uppercase">Manage Website</h5>
    
                            <ul class="list-unstyled">
                                <li>
                                    <a href="createArticles.php">Create Articles</a>
                                </li>
                                <li>
                                    <a href="editArticles.php">Edit Articles</a>
                                </li>
                                <li>
                                    <a href="addGame.php">Add Games</a>
                                </li>
                                <li>
                                    <a href="editGame.php">Edit Games</a>
                                </li>
                                <li>
                                    <a href="approveReviews.php">Approve Reviews</a>
                                </li>
                                <li>
                                    <a href="manageOrders.php">Manage Orders</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-3 mb-md-0 mb-3">
                            <h5 class="text-uppercase">Manage Accounts</h5>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="manageUsers.php">Manage Users</a>
                                </li>
                                <li>
                                    <a href="manageProfile.php">Manage Profile(Admin)</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-copyright text-center py-3 endFooterStyle">&reg 2019 All Rights Reserved:
                    <a href="#">@UnKnowN.com</a>
                </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="scripts/js/addGame.js"></script>
</body>

</html>