<?php
    session_start();
    
    if (empty($_SESSION['adminUsername'])){
        echo '<script type="text/JavaScript">  
            location.href = \'/login.php\';
            </script>';
    }

    include "scripts/php/dbConnection.php";
    $reviewStatus = false;
    $querySelectRatings = "select * from ratings where approved_status = '$reviewStatus'";
    $resultUnApprovedReviews = mysqli_query($con, $querySelectRatings);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/all.min.css">
        <link rel="stylesheet" type="text/css" href="/css/editGames.css">
        <link rel="stylesheet" href="css/style.css">
        <title>Motion Gaming - Edit Game</title>
    </head>
    <body>
    <?php
	    include "includes/adminIndexHeader.php";    
    ?>
        <br>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1 col-sm-1 col-xs-1">
                </div>
                <div class="col-md-10 col-sm-10 col-xs-10">
                    <form class="formArticle rounded" method="POST" style="background: transparent;">
                        <h2>Approve or Delete Reviews</h2>
                        <div style="height: 850px; overflow: auto;">
                            <table class="table table-hover table-dark rounded">
                                <thead>
                                    <tr>
                                        <th scope="col">ID#</th>
                                        <th scope="col">Users</th>
                                        <th scope="col">Games</th>
                                        <th scope="col">Ratings</th>
                                        <th scope="col">Comments</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Approve</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($row = mysqli_fetch_array($resultUnApprovedReviews)){
                                            $ratingID = $row['rating_id'];
                                            $userID = $row['user_id'];
                                            $gameID = $row['game_id'];
                                            $ratedValue = $row['rated_value'];
                                            $date = $row['date'];
                                            $comments = $row['user_comments'];

                                            $querySelectUser = "select user_name from users where user_id = '$userID'";
                                            $querySelectGame = "select game_name from games where game_id = '$gameID'";
                                            $resultUsers = mysqli_query($con, $querySelectUser);
                                            $resultGames = mysqli_query($con, $querySelectGame);

                                            while ($uRow = mysqli_fetch_array($resultUsers)){
                                                $userName = $uRow['user_name'];
                                            }

                                            while ($gRow = mysqli_fetch_array($resultGames)){
                                                $gameName = $gRow['game_name'];
                                            }
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $ratingID ?></th>
                                        <td><?php echo $userName ?></td>
                                        <td><?php echo $gameName ?></td>
                                        <td><?php echo $ratedValue ?></td>
                                        <td><?php echo $comments ?></td>
                                        <td><?php echo $date ?></td>
                                        <td><a role="button" class="btn btn-success" href="SubsideryPages/approveRating.php?id=<?php echo base64_encode($ratingID) ?>">Approve</a></td>
                                        <td><a role="button" class="btn btn-danger" href="SubsideryPages/deleteRating.php?id=<?php echo base64_encode($ratingID) ?>">Delete</a></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1">
                </div>
            </div>
        </div>
        
        <?php
	        include "includes/adminIndexFooter.php";    
        ?>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                crossorigin="anonymous">
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous">
        </script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous">
        </script>
    </body>
</html>