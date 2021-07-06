<?php
    session_start();
    include "scripts/php/dbConnection.php";

    if ((empty($_SESSION['username'])) && (empty($_SESSION['adminUsername']))){
        echo '<script>location.href = \'/login.php\'; </script>';
    }

    function makeQuery(){
        global $con;

        if (!(empty($_SESSION['adminUsername']))){
            $oldPassword = addslashes($_POST['oldPasswordField']);
            $newPassword = addslashes($_POST['newPasswordField']);
            $email = addslashes($_POST['emailField']);
            $adminName = $_SESSION['adminUsername'];
            
            $selectQuery = "select * from admins where admin_name = '$adminName'";
            $resultAdminID = mysqli_query($con, $selectQuery);
            while ($row = mysqli_fetch_array($resultAdminID)){
                $adminId = $row['admin_id'];
                $storedHashedPassword = $row['password'];
            }

            if (password_verify($oldPassword, $storedHashedPassword)){
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updatequery = "update admins set password = '$newHashedPassword', email = '$email' where admin_id = '$adminId'";

                if (mysqli_query($con, $updatequery)){
                    echo '<script type="text/JavaScript">  
                    alert("Admin ('.$_SESSION['adminUsername'].') has been updated!");
                    location.href = \'/adminIndex.php\';  
                    </script>';
                }
            }else{
                echo '<script>alert("Old Password didn\'t match!")</script>';
            }
        } else if (!(empty($_SESSION['username']))) {
            $oldPassword = addslashes($_POST['oldPasswordField']);
            $newPassword = addslashes($_POST['newPasswordField']);
            $email = addslashes($_POST['emailField']);
            $userName = $_SESSION['username'];
            
            $selectQuery = "select * from users where user_name = '$userName'";
            $resultUserID = mysqli_query($con, $selectQuery);
            while ($row = mysqli_fetch_array($resultUserID)){
                $userId = $row['user_id'];
                $storedHashedPassword = $row['password'];
            }
            
            if (password_verify($oldPassword, $storedHashedPassword)){
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updatequery = "update users set password = '$newHashedPassword', email = '$email' where user_id = '$userId'";

                if (mysqli_query($con, $updatequery)){
                    echo '<script type="text/JavaScript">  
                    alert("User ('.$_SESSION['username'].') has been updated!");
                    location.href = \'/index.php\'; 
                    </script>';
                }    
            }else{
                echo '<script>alert("Old Password didn\'t match!")</script>';
            } 
        }
    }

    $articleIDS = [];
    $articleSelectQuery = "select * from articles";
    $articleselectResult = mysqli_query($con, $articleSelectQuery);
    $counter = 0;
    function fillArticleIDS(){
        global $articleIDS, $counter, $articleselectResult;
        while ($row = mysqli_fetch_array($articleselectResult)){
            $articleIDS[$counter] = $row['article_id'];
            $counter++;
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
    <link rel="stylesheet" href="css/articlesCreationStyle.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Motion Gaming - Manage Profile</title>
</head>

<body>
    <script src="scripts/js/createArticleInsertion.js"></script>
    <?php
        if (!empty($_SESSION['username'])){
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-lg fixed-top">
        <a class="navbar-brand ml-50 p-2" href="index.php"><h2 class="brandIcon"><span style="font-weight:bolder">Motion</span> Gaming</h2></a>
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
    <?php
        }
    ?>

    <?php
        if (!empty($_SESSION['adminUsername'])){
	        include "includes/adminIndexHeader.php";
        }
    ?>
    
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1 col-sm-1 col-xs-1">
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
                <form class="formArticle rounded" method="POST" enctype="multipart/form-data">
                    <div class="form-group inputBox">
                        <?php
                            if (!(empty($_SESSION['adminUsername']))){
                        ?>
                        <Label>Username: (<?php echo $_SESSION['adminUsername'] ?>)</Label>
                        <?php
                            } else if (!(empty($_SESSION['username']))) {
                        ?>
                        <Label>Username: (<?php echo $_SESSION['username'] ?>)</Label>
                        <?php
                            }
                        ?>
                        <div class="dateInputBox" style="border-top: 2px solid gray;">
                            <label>Change Password?</label>
                            <label for="oldPassword">Old Password: </label>
                            <input class="form-control" type="password" name="oldPasswordField" id="oldPassword" placeholder="Old Password" required autofocus>
                            <label for="newPassword">New Password: </label>
                            <input class="form-control" type="password" name="newPasswordField" id="newPassword" placeholder="New Password" required>
                        </div>
                        <div class="">
                            <label>Set you email: </label>
                            <input class="form-control" type="email" name="emailField" id="email" placeholder="Your Email here!" required>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="form-control btn btn-success" name="submit" id="submitArticle"
                            onclick="verifyUpdationFields(oldPasswordField, newPasswordField, email)">Submit Profile Changes</button>
                        </div>
                        <div class="invisible">
                            <input type="checkbox" name="uploadStatusField" id="uploadStatus" value="">
                            <input type="hidden" name="uploadVal" id="upload">
                        </div> 
                    </div>
                    <?php
                        if(isset($_POST['submit']) && ($_POST['uploadVal'] == '1')){
                            makeQuery();
                        }
                    ?>
                </form>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
            </div>
        </div>
    </div>

    <?php
        if (!empty($_SESSION['username'])){
            include "includes/indexFooter.php";
        }
    ?>

    <?php
        if (!empty($_SESSION['adminUsername'])){
            include "includes/adminIndexFooter.php";
        }
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="scripts/js/manageProfile.js"></script>
</body>

</html>