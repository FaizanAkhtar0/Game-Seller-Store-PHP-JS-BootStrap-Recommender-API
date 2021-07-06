<?php
    session_start();
    include "scripts/php/dbConnection.php";

    $querySelect = "select * from articles ORDER BY article_id DESC";
    $articleIds = [];
    $articleTitle = "";
    $articlePublishDate = "";
    $articleContent = "";
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
    <link rel="stylesheet" href="css/viewArticleStyles.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Motion Gaming - Articles</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-lg fixed-top">
        <a class="navbar-brand ml-50 p-2" href="index.php">
            <h2 class="brandIcon"><span style="font-weight:bolder">Motion</span> Gaming</h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
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
                    if (empty($_SESSION['username'])) {
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 m-0 p-0">
                <div class="StaticSlider">
                    <form>
                        <div>
                            <div class="articles">
                                <h2>Artciles</h2>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="container-fluid">
        <div class="row rounded">
            <div class="col-md-1 col-sm-1 col-xs-1"></div>
            <div class="col-md-10 col-sm-10 col-xs-10 colShadow rounded">
                <?php
                $count = 0;
                while ($rowData = mysqli_fetch_array($result)) {
                    $articleTitle = $rowData['article_title'];
                    $articlePublishDate = $rowData['publish_date'];
                    $articleContent = $rowData['article_description'];
                    $articleIds[$count] = $rowData['article_id'];
                    $articleImage = $rowData['article_image'];
                ?>
                    <div class="row">
                        <div class="articleContents">
                            <div class="articleImages">
                                <img class="rounded" src="data:image/jpeg;base64,<?php echo base64_encode($articleImage); ?>">
                            </div>
                            <div class="articleWrittenContents">
                                <h2><?php echo $articleTitle ?></h2>
                                <div class="date"><?php echo $articlePublishDate ?></div>
                                <p><?php echo $articleContent ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                    $count++;
                }
                ?>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1"></div>
        </div>
    </div>
    <br>

    <div class="prefooterStyle">
        <div class="bg bg-fixed bg-pattern bg-img page-footer bg-section-padding-100-0">
            <div class="" style="background: rgba(0,0,0,0.4); padding: 70px 50px;">
                <h1 style="color: white; padding-bottom: 10px;">Latest Article</h1>
                <div class="container-fluid bg-container">
                    <div class="row rounded">
                        <div class="col-md-12 col-sm-12 col-xs-12 colShadow rounded">
                            <?php
                            $lastid = $articleIds[0];
                            $queryForlatestArticle = "select * from articles where article_id = '$lastid'";
                            $latestArticleData = mysqli_query($con, $queryForlatestArticle);
                            while ($row = mysqli_fetch_array($latestArticleData)) {
                                $latestArticleTitle = $row['article_title'];
                                $latestArticlePublishDate = $row['publish_date'];
                                $latestArticleContent = $row['article_description'];
                                $latestArticleImage = $row['article_image'];
                            ?>
                                <div class="row">
                                    <div class="articleContent">
                                        <div class="articleImages">
                                            <img class="rounded" src="data:image/jpeg;base64,<?php echo base64_encode($latestArticleImage); ?>">
                                        </div>
                                        <div class="articleWrittenContents">
                                            <h2><?php echo $latestArticleTitle ?></h2>
                                            <div class="date"><?php echo $latestArticlePublishDate ?></div>
                                            <p><?php echo $latestArticleContent ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        include "includes/indexFooter.php";
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>