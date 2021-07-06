<?php
    include "scripts/php/dbConnection.php";
    session_start();

    if (!empty($_REQUEST['lim'])){
        $tempLim = $_REQUEST['lim'];
        $lim = base64_decode($tempLim);
    }else{
        $lim = 10;
    }

    $game_Ids_json;
    $game_ids = [];
    $gameSelectionFieldData = [];
    $gameRemainingData = [];
    $gameData_json;
    $gameTitles_json;

    function getGamesAndIDS()
    {
        global $con, $game_ids, $gameSelectionFieldData, $gameRemainingData, $gameData_json, $game_Ids_json, $gameTitles_json;
        $query = "select * from games";
        $result = mysqli_query($con, $query);
        $counter = 0;
        $game_titles = [];
        while ($row = mysqli_fetch_array($result)) {
            $game_ids[$counter] = $row['game_id'];
            $game_titles[$counter] = $row['game_name'];
            $gameSelectionFieldData[$counter] = $row['game_id'] . "|" . $row['game_name'];
            $gameRemainingData[$counter] = $row['category'] . "|" . $row['date'] . "|" . $row['description'] . "|" . $row['price'];
            $counter++;
        }
        $gameData_json = json_encode($gameRemainingData);
        $game_Ids_json = json_encode($game_ids);
        $gameTitles_json = json_encode($game_titles);
    }

    function makeInsertQuery()
    {
        global $con;
        if (!(empty($_SESSION['username']))) {
            $user = $_SESSION['username'];
            $selectQuery = "select * from users where user_name = '$user'";
            $result = mysqli_query($con, $selectQuery);
            while ($row = mysqli_fetch_array($result)) {
                $uid = $row['user_id'];
                $gid = $_POST['selectionField'];
                $ratedVal = $_POST['ratedValueField'];
                $date = date("d/m/y", time());
                $uComment = addslashes($_POST['commentsField']);
                $insertQuery = "insert into ratings(user_id, game_id, rated_value, date, user_comments) values('$uid', '$gid', '$ratedVal', '$date', '$uComment')";
                if (mysqli_query($con, $insertQuery)) {
                    echo '<script>alert("You Rated: \"' . $ratedVal . '\" Stars")</script>';
                }
            }
        } else {
            echo '<script>alert("Please Login First!")</script>';
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/gameReviewStyles.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Motion Gaming - Game Reviews</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="viewArticles.php">Articles</a>
                </li>
                <li class="nav-item active">
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
                            <div class="reviews">
                                <h2>Reviews</h2>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>

    <main role="main" class="container">
        <div class="jumbotron h-25">
            <form method="POST">
                <h1>Leave a review for your favourite game</h1>
                <p class="lead pt-10 pb-10">Please share any or all of your thoughts with the developers. We'll be very happy and we appericiate your support!</p>
                <div class="input-group mb-3">
                    <?php
                    getGamesAndIDS();
                    ?>
                    <select class="custom-select" name="selectionField" id="gameSelect">
                        <option selected>Choose...</option>
                        <?php
                        for ($i = 0; $i < count($gameSelectionFieldData); $i++) {
                            $tempStr = $gameSelectionFieldData[$i];
                            $tempArr = explode("|", $tempStr);
                        ?>
                            <option value="<?php echo $tempArr[0] ?>"><?php echo $tempArr[1] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <div class="input-group-append">
                        <label class="input-group-text" for="gameSelect">Select Game</label>
                    </div>
                </div>
                <div class="container">
                    <label>Rate your game: </label>
                    <span class="fa fa-star checked" id="1star" onmouseover="starmark(this)" onclick="starmark(this)" style="font-size: 20px; cursor: pointer;"></span>
                    <span class="fa fa-star checked" id="2star" onmouseover="starmark(this)" onclick="starmark(this)" style="font-size: 20px; cursor: pointer;"></span>
                    <span class="fa fa-star checked" id="3star" onmouseover="starmark(this)" onclick="starmark(this)" style="font-size: 20px; cursor: pointer;"></span>
                    <span class="fa fa-star checked" id="4star" onmouseover="starmark(this)" onclick="starmark(this)" style="font-size: 20px; cursor: pointer;"></span>
                    <span class="fa fa-star checked" id="5star" onmouseover="starmark(this)" onclick="starmark(this)" style="font-size: 20px; cursor: pointer;"></span>
                    <input type="hidden" name="ratedValueField" id="ratedValue" value="">
                </div>
                <div class="input-group">
                    <input type="text" name="commentsField" id="comments" class="form-control" placeholder="Leave your thoughts about the game...">
                    <div class="input-group-append">
                        <button type="submit" name="submitBtn" class="btn btn-dark rounded" onclick="validateRating(gameSelect, comments)">Submit Rating</button>
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Submit</a>
                            <a class="dropdown-item" href="#">Reset</a>
                            <div role="separator" class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Delete my review</a>
                        </div>
                    </div>
                </div>
                <div class="invisible">
                    <input type="checkbox" name="uploadStatusField" id="uploadStatus" value="">
                    <input type="hidden" name="uploadVal" id="upload" value="">
                </div>
                <?php
                if (isset($_POST['submitBtn']) && ($_POST['uploadVal'] == '1')) {
                    makeInsertQuery();
                }
                ?>
            </form>
        </div>
    </main>
    <br>
    <div class="container-fluid">
        <a class="btn btn-light" href="viewReviews.php?lim=<?php echo base64_encode(($lim + 10)) ?>"><b>Load more</b></a>
        <label class="lead ml-5 mt-2">Loaded Reviews: <b><?php echo $lim; ?></b></label>
    </div>
    <br>
    <div class="container-fluid">
        <div class="colShadow rounded">
            <?php
            $reviewStatus = true;
            $querySelectReviews = "select * from ratings where approved_status = '$reviewStatus' order by rating_id LIMIT ".$lim.";";
            $resultReviews = mysqli_query($con, $querySelectReviews);

            while ($row = mysqli_fetch_array($resultReviews)) {
                $gID = $row['game_id'];
                $uID = $row['user_id'];
                $querySelectUser = "select user_name from users where user_id = '$uID'";
                $querySelectGame = "select * from games where game_id = '$gID'";

                $resultUsers = mysqli_query($con, $querySelectUser);

                while ($uRow = mysqli_fetch_array($resultUsers)) {
                    $userName = $uRow['user_name'];
                }

                $resultGames = mysqli_query($con, $querySelectGame);

                while ($gRow = mysqli_fetch_array($resultGames)) {
                    $gameTitle = $gRow['game_name'];
                    $reviewDate = $row['date'];
                    $gameImage = $gRow['image'];
                    $reviewContent = $row['user_comments'];
                    $ratedValue = $row['rated_value'];
                    $userAndDate = "By: (" . $userName . ") On: " . $reviewDate . "";
            ?>
                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-1"></div>
                        <div class="col-md-10 col-sm-10 col-xs-10 rounded">
                            <div class="row">
                                <div class="reviewContent">
                                    <div class="reviewImage">
                                        <img class="rounded" src="data:image/jpeg;base64,<?php echo base64_encode($gameImage); ?>">
                                    </div>
                                    <div class="reviewWrittenContent">
                                        <h2><?php echo $gameTitle ?></h2>
                                        <h6><?php echo $userAndDate ?></h6>
                                        <p><?php echo $reviewContent ?></p>
                                    </div>
                                    <div class="productRating">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $ratedValue) {
                                        ?>
                                                <span class="fa fa-star checked" style="font-size: 20px; cursor: pointer;"></span>
                                            <?php
                                            } else {
                                            ?>
                                                <span class="fa fa-star" style="font-size: 20px; cursor: pointer;"></span>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-1"></div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <br>

    <?php
        include "includes/indexFooter.php";
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="/scripts/js/calculateRating.js"></script>
</body>

</html>