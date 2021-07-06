<?php
    session_start();
    include "scripts/php/dbConnection.php";
    $idAndDates_json;
    $validDate;
    $id;
    $gID;
    $idAndDates = [];
    if (empty($_SESSION['username'])) {
        echo '<script type="text/JavaScript">  
                location.href = \'/login.php\';
                </script>';
    } else {
        $username = $_SESSION['username'];
        $querySelectUser = "select user_id from users where user_name = '$username'";
        $resultUser = mysqli_query($con, $querySelectUser);

        while ($row = mysqli_fetch_array($resultUser)) {
            $id = $row['user_id'];
        }
    }

    $articleIDS = [];
    $counter = 0;
    function fillArticleIDS()
    {
        global $con, $articleIDS, $counter, $articleselectResult;
        $articleSelectQuery = "select * from articles";
        $articleselectResult = mysqli_query($con, $articleSelectQuery);

        while ($row = mysqli_fetch_array($articleselectResult)) {
            $articleIDS[$counter] = $row['article_id'];
            $counter++;
        }
    }

    function makeQuery()
    {
        global $con, $validDate;
        $orderID = $_POST['selectionField'];

        $querySelectDate = "select code_validation_date from orders where order_id = '$orderID'";
        $resultDate = mysqli_query($con, $querySelectDate);

        while ($dRow = mysqli_fetch_array($resultDate)) {
            $validDate = $dRow['code_validation_date'];
        }

        $todayDate = date('d/m/Y', time());
        $validationDate = $validDate;
        if (compareDates($todayDate, $validationDate) == 0) {
            $inputCode = $_POST['codeField'];
            $querySelectVerificationCode = "select receiving_code, game_id from orders where order_id = '$orderID'";
            $resultCode = mysqli_query($con, $querySelectVerificationCode);

            while ($row = mysqli_fetch_array($resultCode)) {
                $fetchCode = $row['receiving_code'];
                $gID = $row['game_id'];

                if ($inputCode != $fetchCode) {
                    echo '<script>alert("Code did not match, Invalid Code!")</script>';
                } else {
                    $updateDownloads = "update orders set no_of_downloads = no_of_downloads+1 where order_id = '$orderID'";
                    if (mysqli_query($con, $updateDownloads)) {
                        echo '<script>alert("Downloads updated!");
                                location.href = \'/downloadGame.php?id=' . base64_encode($gID) . '\';   
                                </script>';
                    } else {
                        echo '<script>alert("Unable to update downloads!")</script>';
                    }
                }
            }
        } else {
            $status = true;
            $queryStatusSet = "update orders set exp_status = '$status' where order_id = '$orderID'";
            mysqli_query($con, $queryStatusSet);
            echo '<script>alert("Your access for this order for 2 months has expired! Please place a new order for this game.");
                location.href = \'/accessOrders.php\';
                </script>';
        }
    }

    function compareDates($TodayDate, $ValidDate)
    {
        $TodayDateStr = (string) $TodayDate;
        $ValidDateStr = (string) $ValidDate;

        $tempArr1 = explode("/", $TodayDateStr);
        $tempArr2 = explode("/", $ValidDateStr);

        $date1Day = $tempArr1[0];
        $date1Month = $tempArr1[1];
        $date1Year = $tempArr1[2];

        $date2Day = $tempArr2[0];
        $date2Month = $tempArr2[1];
        $date2Year = $tempArr2[2];

        $intDate1Day = (int) $date1Day;
        $intDate2Day = (int) $date2Day;

        $intDate1Month = (int) $date1Month;
        $intDate2Month = (int) $date2Month;

        $intDate1Year = (int) $date1Year;
        $intDate2Year = (int) $date2Year;

        $intYearDiff = $intDate2Year - $intDate1Year;
        $intMonthDiff = $intDate2Month - $intDate1Month;
        $intDayDiff = $intDate2Day - $intDate1Day;

        if ($intYearDiff > 0) {
            return 1;
        } else if ($intYearDiff == 0) {
            if ($intMonthDiff > 0) {
                return 1;
            } else if ($intMonthDiff == 0) {
                if ($intDayDiff > 0) {
                    return 1;
                } else {
                    return -1;
                }
            } else {
                return -1;
            }
        } else {
            return -1;
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
    <link rel="stylesheet" href="css/style.css">
    <title>Motion Gaming - Order Access</title>
    <style>
        #selectedOrderDate {
            transition: all 0.2s ease;
            font-size: 15px;
        }

        #selectedOrderDate:hover {
            color: red;
            font-weight: bold;
            transform: scale(1.2);
        }
    </style>
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
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="viewArticles.php">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="viewReviews.php">Games Reviews</a>
                </li>
                <li class="nav-item active">
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
    <br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1 col-sm-1 col-xs-1">
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
                <div class="row">
                    <div class="col-md-1 col-sm-1 col-xs-1"></div>
                    <div class="col-md-10 col-sm-10 col-xs-10 justify-content-center">
                        <form class="rounded mt-5" method="POST">
                            <h2>You can access your placed orders here</h2>
                            <div class="form-group">
                                <div class="">
                                    <div class="input-group mb-3">
                                        <?php
                                        $status = false;
                                        $querySelectGame = "select * from orders where user_id = '$id' AND exp_status = '$status'";
                                        $result = mysqli_query($con, $querySelectGame);
                                        ?>
                                        <select class="custom-select" name="selectionField" id="orderSelect" onchange="fillExpDate(this)">
                                            <option value="-1">Choose</option>
                                            <?php
                                            $count = 0;
                                            while ($row = mysqli_fetch_array($result)) {
                                                $orderID = $row['order_id'];
                                                $gID = $row['game_id'];
                                                $codeValidDate = $row['code_validation_date'];
                                                $idAndDates[$count] =  $orderID . "|" . $codeValidDate;
                                                $querySelectGame = "select game_name from games where game_id = '$gID'";
                                                $resultGame = mysqli_query($con, $querySelectGame);

                                                while ($gRow = mysqli_fetch_array($resultGame)) {
                                                    $gameName = $gRow['game_name'];
                                                }
                                            ?>
                                                <option value="<?php echo $orderID ?>"><?php echo $orderID . " - " . $gameName ?></option>
                                            <?php
                                                $count++;
                                            }
                                            $idAndDates_json = json_encode($idAndDates);
                                            ?>
                                        </select>
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="orderSelect">Selected Order</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <textarea class="form-control" rows="5" name="codeField" id="code" placeholder="Enter the 'Validation Code' that you received from our courier after payment to verify payment and begin downloading." required></textarea>
                                </div>
                            </div>
                            <div class="form-group justify-content-center">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <button type="submit" name="submit" id="submitEditedgame" class="form-control btn btn-outline-success btn-lg" onclick="checkForm(orderSelect, code)">Submit Code</button>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <a class="form-control btn btn-danger btn-lg" role="button" onclick="" href="index.php">Cancel Redeem</a>
                                    </div>
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
                        <div class="row justify-content-center">
                            <div style="visibility: hidden;" id="selectedOrderDate" class="mb-4">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1"></div>
                </div>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-1">
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

    <script src="scripts/js/orderAccess.js"></script>
    <script type="text/javascript">
        function fillExpDate(item) {
            document.getElementById("selectedOrderDate").innerHTML = "";

            var selectedID = item.value;
            if (selectedID == "-1") {
                document.getElementById("selectedOrderDate").innerHTML = "Please select an order to view expiry date here!";
                document.getElementById("selectedOrderDate").style.visibility = 'visible';
                return;
            }


            var tempArrIDandDates = JSON.parse('<?= addslashes($idAndDates_json); ?>');
            var ids = [];
            var dates = [];
            var counter = 0;
            for (var i = 0; i < tempArrIDandDates.length; i++) {
                var tempstr = tempArrIDandDates[counter].split("|");
                ids[counter] = tempstr[0];
                dates[counter] = tempstr[1];
                counter++;
            }

            document.getElementById("selectedOrderDate").innerHTML = "Your order expires on " + dates[ids.indexOf(selectedID)] + ""
            document.getElementById("selectedOrderDate").style.visibility = 'visible';
        }
    </script>
</body>

</html>