<?php
    session_start();

    if (empty($_SESSION['adminUsername'])) {
        echo '<script type="text/JavaScript">  
                location.href = \'/login.php\';
                </script>';
    }

    include "scripts/php/dbConnection.php";
    $querySelectUsers = "select * from users";
    $resultRegisteredUsers = mysqli_query($con, $querySelectUsers);
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
    <title>Motion Gaming - Manage Users</title>
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
                    <h2>Manage Users for your site</h2>
                    <div style="height: 850px; overflow: auto;">
                        <table class="table table-hover table-dark rounded">
                            <thead>
                                <tr>
                                    <th scope="col">ID#</th>
                                    <th scope="col">Usernames</th>
                                    <th scope="col">Hashed Passwords</th>
                                    <th scope="col">Emails</th>
                                    <th scope="col">Delete User</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($resultRegisteredUsers)) {
                                    $userID = $row['user_id'];
                                    $username = $row['user_name'];
                                    $password = $row['password'];
                                    $email = $row['email'];
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $userID ?></th>
                                        <td><?php echo $username ?></td>
                                        <td><?php echo $password ?></td>
                                        <td><?php echo $email ?></td>
                                        <td><a role="button" class="btn btn-danger" href="SubsideryPages/deleteUser.php?id=<?php echo base64_encode($userID) ?>">Delete</a></td>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>