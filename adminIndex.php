<?php
    session_start();
    
    if (empty($_SESSION['adminUsername'])){
        echo '<script type="text/JavaScript">  
            location.href = \'/login.php\';
            </script>';
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/all.min.css">
        <link rel="stylesheet" href="css/adminStyles.css">
        <link rel="stylesheet" href="css/style.css">
        <title>Motion Gaming - Admin</title>
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
                    <form class="formArticle rounded">
                        <div class="form-group inputBox">
                            <Label>Manager your website here!</Label>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <a class="btn btn-lg expandingButton" href="createArticles.php" role="button">Create a new artcile</a>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <a class="btn btn-lg expandingButton" href="editArticles.php" role="button">Edit/Delete artciles</a>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <a class="btn btn-lg expandingButton" href="addGame.php" role="button">Add a new Game</a>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <a class="btn btn-lg expandingButton" href="editGame.php" role="button">Edit/Delte Games</a>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <a class="btn btn-lg expandingButton" href="approveReviews.php" role="button">Approve new Reviews</a>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <a class="btn btn-lg expandingButton" href="manageUsers.php" role="button">Manage Users</a>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <a class="btn btn-lg expandingButton" href="manageOrders.php" role="button">Manage Orders</a>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <a class="btn btn-lg expandingButton" href="manageProfile.php" role="button">Manage Profile</a>
                                </div>
                            </div>
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