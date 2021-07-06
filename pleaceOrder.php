<?php
    session_start();

    if (empty($_SESSION['username'])) {
        echo '<script type="text/JavaScript">  
                location.href = \'/login.php\';
                </script>';
    }

    include "scripts/php/dbConnection.php";

    if (empty($_REQUEST['id'])) {
        if (!(empty($_SESSION['username']))) {
            echo '<script>
                    location.href = \'/index.php\';        
                    </script>';
        } else {
            echo '<script>
                    location.href = \'/login.php\';        
                    </script>';
        }
    } else {
        $tempID = $_REQUEST['id'];
        $id = base64_decode($tempID);
    }

    $price = "";
    $category = "";
    $image;
    function makeQuery()
    {
        global $con, $id;
        if (!(empty($_SESSION['username']))) {
            $username = $_SESSION['username'];
            $querySelectUser = "select user_id from users where user_name = '$username'";
            $resultUser = mysqli_query($con, $querySelectUser);
            while ($uRow = mysqli_fetch_array($resultUser)) {
                $uID = $uRow['user_id'];
            }
            $phoneNumber = $_POST['phonenoField'];
            $Address = addslashes($_POST['addressField']);
            $receivingCode = bin2hex(openssl_random_pseudo_bytes(32));
            $codeValidationDate = date('d/m/Y', strtotime('+2 months'));
            $noOfDownloads = 0;
            $queryInsert = "insert into orders(user_id, game_id, phone_no, address, receiving_code, code_validation_date, no_of_downloads) values('$uID','$id','$phoneNumber','$Address','$receivingCode','$codeValidationDate','$noOfDownloads')";

            if (mysqli_query($con, $queryInsert)) {
                echo '<script type="text/JavaScript">  
                    alert("Your Order has been placed in the processing queue!"); 
                    location.href = \'/index.php\';
                    </script>';
            }
        } else {
            echo '<script type="text/JavaScript">  
                    alert("You are not logged in!"); 
                    </script>';
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
    <link rel="stylesheet" href="css/signupStyles.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/orderStyles.css">
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


    <div class="container-fluid containerOrderBackground">
        <div class="row">
            <div class="col-md-1 col-xs-1"></div>
            <div class="col-md-10 col-xs-10">
                <div style="margin-top: 100px">
                    <div class="rounded OrderForm">
                        <form class="form-signin rounded" method="POST">
                            <div class="formContent rounded" style="margin-left: 55%">
                                <h1>Place your Order</h1>
                                <div class="input-group mb-3">
                                    <?php
                                    $querySelectGame = "select * from games where game_id = '$id'";
                                    $result = mysqli_query($con, $querySelectGame);
                                    ?>
                                    <select class="custom-select" name="selectionField" id="inputGroupSelect01">
                                        <?php
                                        while ($row = mysqli_fetch_array($result)) {
                                            $gameName = $row['game_name'];
                                            $gamePrice = $row['price'];
                                            $gameCategory = $row['category'];
                                            $price = $gamePrice;
                                            $category = $gameCategory;
                                            $gameImage = $row['image'];
                                        ?>
                                            <option><?php echo $gameName ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="inputGroupSelect01">Selected Game</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="number" id="price" name="priceField" class="form-control" placeholder="Price (<?php echo $price ?>)" value="<?php echo $price ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="category" name="categoryField" class="form-control" placeholder="Category (<?php echo $category ?>)" value="<?php echo $category ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="phoneNo" name="phonenoField" class="form-control" placeholder="Phone no" autocomplete required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="address" name="addressField" class="form-control" placeholder="Full Address City, Street etc." autocomplete required autofocus>
                                </div>
                                <div class="ml-4">
                                    <button type="submit" name="submit" class="btn btn-warning rounded btn-block btnSignup" onclick="ValidateInput()"><b>Confirm Order</b></button>
                                    <a role="button" href="index.php" class="btn btn-outline-primary rounded btn-block btnSignup" onclick=""><b>Cancel Order</b></a>
                                </div>
                                <div class="invisible">
                                    <input type="checkbox" name="uploadStatusField" id="uploadStatus" value="">
                                    <input type="hidden" name="uploadVal" id="upload">
                                </div>
                            </div>
                            <?php
                            if (isset($_POST['submit']) && ($_POST['uploadVal'] == '1')) {
                                makeQuery();
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1 col-xs-1"></div>
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

    <script>
        var uploadFlag = false;

        function ValidateInput() {
            var phone = document.getElementById("phoneNo").value;
            var address = document.getElementById("address").value;

            if (phone == '') {
                alert("Please input a valid phone number!");
                return;
            } else {
                uploadFlag = true;
            }

            if (address == '') {
                alert("You must input your full address verify payment and to recieve verfifcation code!");
                return;
            } else {
                uploadFlag = true;
            }

            if (uploadFlag) {
                document.getElementById("upload").value = 1;
                document.getElementById("uploadStatus").checked = true;
            }
        }
    </script>
</body>

</html>