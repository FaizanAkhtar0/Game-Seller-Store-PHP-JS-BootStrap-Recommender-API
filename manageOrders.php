<?php
    session_start();

    if (empty($_SESSION['adminUsername'])) {
        echo '<script type="text/JavaScript">  
                location.href = \'/login.php\';
                </script>';
    }

    include "scripts/php/dbConnection.php";
    $querySelectOrders = "select * from orders";
    $resultOrders = mysqli_query($con, $querySelectOrders); 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/editGames.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Motion Gaming - Manage Orders</title>
</head>

<body>
    <?php
        include "includes/adminIndexHeader.php";    
    ?>
    <br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form class="formArticle rounded" method="POST" style="background: transparent;">
                    <h2>Manage orders for your games</h2>
                    <div style="height: 850px; overflow: auto;">
                        <table class="table table-hover table-dark rounded">
                            <thead>
                                <tr>
                                    <th scope="col">ID#</th>
                                    <th scope="col">Usernames</th>
                                    <th scope="col">Games</th>
                                    <th scope="col">Phone Numbers</th>
                                    <th scope="col">Addresses</th>
                                    <th scope="col">Receiving Codes</th>
                                    <th scope="col">Code Validation Dates</th>
                                    <th scope="col">No# of downloads</th>
                                    <th scope="col">Expiring Date</th>
                                    <th scope="col">Generate Invoice</th>
                                    <th scope="col">Delete Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($resultOrders)) {
                                    $orderID = $row['order_id'];
                                    $userID = $row['user_id'];
                                    $gameID = $row['game_id'];
                                    $phoneNo = $row['phone_no'];
                                    $address = $row['address'];
                                    $receivingCode = $row['receiving_code'];
                                    $recCodeValidationDate = $row['code_validation_date'];
                                    $noOfDownloads = $row['no_of_downloads'];
                                    $exp_status = $row['exp_status'];

                                    $querySelectUser = "select user_name from users where user_id = '$userID'";
                                    $resultUser = mysqli_query($con, $querySelectUser);

                                    while ($uRow = mysqli_fetch_array($resultUser)) {
                                        $username = $uRow['user_name'];
                                    }

                                    $querySelectGame = "select game_name from games where game_id = '$gameID'";
                                    $resultGame = mysqli_query($con, $querySelectGame);

                                    while ($gRow = mysqli_fetch_array($resultGame)) {
                                        $gamename = $gRow['game_name'];
                                    }
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $orderID ?></th>
                                        <td><?php echo $username ?></td>
                                        <td><?php echo $gamename ?></td>
                                        <td><?php echo $phoneNo ?></td>
                                        <td><?php echo $address ?></td>
                                        <td><?php echo $receivingCode ?></td>
                                        <td><?php echo $recCodeValidationDate ?></td>
                                        <td><?php echo $noOfDownloads ?></td>
                                        <td>
                                            <?php
                                            if ($exp_status == "1") {
                                                echo "Expired";
                                            } else {
                                                echo "Valid";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                        <?php
                                            if ($exp_status == "1") {
                                                
                                            }else{
                                        ?>
                                                <a role="button" class="btn btn-info" href="SubsideryPages/printOrder.php?id=<?php echo base64_encode($orderID) ?>">Print</a></td>
                                        <?php
                                            }
                                        ?>
                                        <td><a role="button" class="btn btn-danger" href="SubsideryPages/deleteOrder.php?id=<?php echo base64_encode($orderID) ?>">Delete</a></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
	    include "includes/adminIndexFooter.php";    
    ?>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>