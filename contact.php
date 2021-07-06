<?php
session_start();
    include "scripts/php/dbConnection.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/contactUsStyles.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Motion Gaming - ContactUs</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="viewReviews.php">Games Reviews</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="accessOrders.php">Downloads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item active">
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
                            <div class="contactus">
                                <h2>Contact Us</h2>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <main role="main" class="container">
        <div class="jumbotron">
            <h1>Get In Touch</h1>
            <p class="lead"> You can also contact us on our email.</p>
            <div class=" container">
                <form class="form-signin">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" id="inputUsername" class="form-control" placeholder="Name*" autocomplete required>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <?php
                                    if (!empty($_SESSION['username'])){
                                        $username = $_SESSION['username'];
                                        $querySelectEmail = "select email from users where user_name = '$username'";
                                        $resultEmail = mysqli_query($con, $querySelectEmail);
                                        while ($row = mysqli_fetch_array($resultEmail)){
                                            $email = $row['email'];
                                ?>
                                <input type="email" id="inputEmail" name="emailField" class="form-control" value="<?php echo $email ?>" placeholder="Email*" autocomplete required>
                                <?php
                                    }
                                }else{
                                ?>
                                <input type="email" id="inputEmail" name="emailField" class="form-control" placeholder="Email*" autocomplete required>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" id="inputSubject" name="subjectField" class="form-control" placeholder="Subject*" autocomplete required>
                    </div>
                    <div class="form-group">
                        <textarea class="col-md-12" rows="4" id="inputMessage" name="bodyField" class="form-control" placeholder="Message*" autocomplete required></textarea>
                    </div>
                    <button type="button" class="btn btn-lg btn-primary" onclick="SendMail()">Send <span class="fa fa-mail-bulk"></span></button>
                </form>
            </div>
        </div>
    </main>

    <?php
        include "includes/indexFooter.php";
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script>
        function SendMail(){
            var email = document.getElementById("inputEmail").value;
            var subject = document.getElementById("inputSubject").value;
            var body = document.getElementById("inputMessage").value;
            window.open('mailto:'+ email +'?subject='+subject+'&body='+body+'');
        }
    </script>
</body>

</html>