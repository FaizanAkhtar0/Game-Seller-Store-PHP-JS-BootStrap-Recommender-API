<?php 
    session_start();
    include "scripts/php/dbConnection.php";
    $count = 0;
    $gameIDS = [];
    $articleIDS = [];
    $querySelect = "select * from games ORDER BY average_rating DESC";
    $result = mysqli_query($con, $querySelect);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/all.min.css">
        <link rel="stylesheet" href="css/style.css">
        <title>Motion Gaming</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-lg fixed-top">
            <a class="navbar-brand ml-50 p-2" href="index.php"><h2 class="brandIcon"><span style="font-weight:bolder">Motion</span> Gaming</h2></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="viewArticles.php">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="viewReviews.php">Games Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="accessOrders.php">Downloads</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            More
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="#">Gaming Softwares</a>
                            <a class="dropdown-item" href="#">Boxed Games</a>
                            <a class="dropdown-item" href="#">Product reviews</a>
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
                                if(empty($_SESSION['username'])){
                        ?>
                        <a role="button" href="signup.php" class="btn btn-outline-light my-2 my-sm-0" type="submit">Login</a>
                        <?php
                            } else {
                        ?>
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="UserDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                                echo $_SESSION['username'];
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

        <div id="customCarousel" class="carousel slide carousel-fade w-76" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#customCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#customCarousel" data-slide-to="1"></li>
                <li data-target="#customCarousel" data-slide-to="2"></li>
                <li data-target="#customCarousel" data-slide-to="3"></li>
                <li data-target="#customCarousel" data-slide-to="4"></li>
                <li data-target="#customCarousel" data-slide-to="5"></li>
                <li data-target="#customCarousel" data-slide-to="6"></li>
                <li data-target="#customCarousel" data-slide-to="7"></li>
                <li data-target="#customCarousel" data-slide-to="8"></li>
            </ol>
            <div class="carousel-inner">
            <div class="carousel-item active">
                    <img class="d-block w-100" src="repository/Trendings/anthem2.jpg" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Game</h5>
                        <p>The Power of Creativity</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="repository/slider/titanfall.jpg" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Game</h5>
                        <p>The Power of Creativity</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="repository/slider/battlefield-v-death-dealer-wallpaper.jpg" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Game</h5>
                        <p>The Power of Creativity</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="repository/slider/Control-4K-Wallpaper.jpg" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Game</h5>
                        <p>The Power of Creativity</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="repository/Trendings/call-of-duty-black-ops-2-6.jpg" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Game</h5>
                        <p>The Power of Creativity</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="repository/Trendings/crysis_aliens.jpg" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Game</h5>
                        <p>The Power of Creativity</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="repository/Trendings/gta panorama 4k.jpg" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Game</h5>
                        <p>The Power of Creativity</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="repository/Trendings/pubg.jpg" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Game</h5>
                        <p>The Power of Creativity</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#customCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#customCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="divWhiteBackground">
            <div class="my-md-4"></div>
            <main role="main" class="container">
                <div class="jumbotron">
                    <h1>Why Motion Gaming?</h1>
                    <p class="lead"> Motion gaming is a video gaming website that provides news, reviews, previews, downloads, and other information on video games. We aim to provide you a platform where you can buy your favourite games based on their categories.</p>
                    <a class="btn btn-lg btn-primary" href="viewArticles.php" role="button">View articles &raquo;</a>
                </div>
            </main>


            <div class="container container-Card">
                <h2 class="">Trending products</h2>
                <p>Select a product to buy.</p>
                <div class="row justify-content-center">
                    <?php
                        while ($row = mysqli_fetch_array($result)){
                            $gameIDS[$count] = $row['game_id'];
                            $gameid = $row['game_id'];
                            global $count;
                            $count++;

                            $gameTitle = $row['game_name'];
                            $gameCategory = $row['category'];
                            $gameDate = $row['date'];
                            $gameDescription = $row['description'];
                            $gamePrice = $row['price'];
                            $gameImage = $row['image'];
                            $totalReviews = $row['total_reviews'];
                            $positiveReviews = $row['positive_review_count'];
                            $negativeReviews = $row['negative_review_count'];
                            $totalRating = $row['total_rating_count'];
                            $averageRating = $row['average_rating'];
                            $ratCount1 = $row['rat_count_1'];
                            $ratCount2 = $row['rat_count_2'];
                            $ratCount3 = $row['rat_count_3'];
                            $ratCount4 = $row['rat_count_4'];
                            $ratCount5 = $row['rat_count_5'];
                    ?>
                    <div class="col-md-4">
                        <div class="card shadow-lg mb-4 card-Spacing" style="width: 23rem;">
                            <div class="inner"><img class="card-img-top rounded" src="data:image/jpeg;base64,<?php echo base64_encode($gameImage); ?>" alt="Card image cap"></div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $gameTitle ?></h5>
                                <p class="card-text" style="heigth: 150px; overflow: hidden; text-overflow: ellipsis;"><?php echo $gameDescription ?></p>
                                <p><b>Date: <?php echo $gameDate ?></b></p>
                                <p><b>Category: <?php echo $gameCategory ?></b></p>
                                <p>Average Rating: <b style="color:darkgreen;"><?php echo $averageRating ?></b></p>
                                <?php 
                                    if (!($totalRating == 0)){
                                ?>
                                <div class="row">
                                    <div class="col-md-8 col-sm-8">
                                        <div class="progress mt-2" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo (($ratCount1 / $totalRating) * 100) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <p style="font-size: 13px;"><b>1 - (<?php echo (($ratCount1 / $totalRating) * 100) ?>%)</b></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-8">
                                        <div class="progress mt-2" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo (($ratCount2 / $totalRating) * 100) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <p style="font-size: 13px;"><b>2 - (<?php echo (($ratCount2 / $totalRating) * 100) ?>%)</b></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-8">
                                        <div class="progress mt-2" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo (($ratCount3 / $totalRating) * 100) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <p style="font-size: 13px;"><b>3 - (<?php echo (($ratCount3 / $totalRating) * 100) ?>%)</b></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-8">
                                        <div class="progress mt-2" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo (($ratCount4 / $totalRating) * 100) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <p style="font-size: 13px;"><b>4 - (<?php echo (($ratCount4 / $totalRating) * 100) ?>%)</b></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-8">
                                        <div class="progress mt-2" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo (($ratCount5 / $totalRating) * 100) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <p style="font-size: 13px;"><b>5 - (<?php echo (($ratCount5 / $totalRating) * 100) ?>%)</b></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-7 col-sm-7">
                                        <div class="progress mt-2" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo (($positiveReviews / $totalReviews) * 100) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <p style="font-size: 13px;"><b style="color: green; font-size: 1rem;">+</b> Reviews <b> - (<?php echo (($positiveReviews / $totalReviews) * 100) ?>%)</b></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7 col-sm-7">
                                        <div class="progress mt-2" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo (($negativeReviews / $totalReviews) * 100) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <p style="font-size: 13px;"><b style="color: red; font-size: 1rem;">-</b> Reviews <b> - (<?php echo (($negativeReviews / $totalReviews) * 100) ?>%)</b></p>
                                    </div>
                                </div>
                                <?php
                                    }else{
                                        echo "<p>Recommendation Info: <b style=\"color: red;\">N/A</b></p>";
                                    }
                                ?>
                                <hr>
                                <div class="btn-group">
                                        <a class="btn btn-light" href="pleaceOrder.php?id=<?php echo base64_encode(($gameid)) ?>"><b>Price: <?php echo $gamePrice ?>$</b></a>
                                        <a class="btn btn-dark" href="pleaceOrder.php?id=<?php echo base64_encode(($gameid)) ?>"><span class="fa fa-cart-plus"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>


        <div class="prefooterStyle">
            <div class="bg bg-fixed bg-pattern bg-img page-footer bg-section-padding-100-0" >
                <div class="" style="background: rgba(0,0,0,0.4); padding: 70px 50px;">
                        <div class="container-fluid bg-container rounded">
                        <h1 style="color: white;">Latest News</h1>
                                <?php 
                                    $newCounter = 0;
                                    $newQuery = "select * from articles ORDER BY article_id DESC";
                                    $newResult = mysqli_query($con, $newQuery);
                                    while ($articleRow = mysqli_fetch_array($newResult)){
                                        if ($newCounter == 5){
                                            break;
                                        }
                                        $articleTitle = $articleRow['article_title'];
                                        $articelDate = $articleRow['publish_date'];
                                        $articleDescription = $articleRow['article_description'];
                                        $articleImage = $articleRow['article_image'];
                                ?>
                                <div class="row rounded">
                                    <div class="col-md-12 col-sm-12 col-xs-12 colShadow rounded">
                                        <div class="row">
                                            <div class="articleContent">
                                                <div class="articleImage">
                                                    <img class="rounded" src="data:image/jpeg;base64,<?php echo base64_encode($articleImage); ?>">
                                                </div>
                                                <div class="articleWrittenContent">
                                                    <h2><?php echo $articleTitle ?></h2>
                                                    <h6><?php echo $articelDate ?></h6>
                                                    <p><?php echo $articleDescription ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                        $newCounter++;
                                    }
                                ?>
                        </div>
                </div>
            </div>
        </div>
    <?php
        include "includes/indexFooter.php";
    ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>