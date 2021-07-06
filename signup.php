<?php
    session_start();
    include "scripts/php/dbConnection.php";

    function makeQuery(){
        global $con;
        $username = addslashes($_POST['usernameField']);
        $email = addslashes($_POST['emailField']);
        $password = addslashes($_POST['passwordField']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "insert into users(user_name, password, email) values('$username', '$hashedPassword', '$email')";
        if (mysqli_query($con, $insertQuery)){
            if (!(is_null($username))){
                $_SESSION["username"] = $username;
                echo '<script>alert("A Session has been Created! for: '.$_SESSION["username"].'");
                location.href = \'/index.php\';  
                    </script>';
            }
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
</head>

<body>
    <div class="container-fluid containerBackground">
        <div class="row">
            <div class="col-md-1 col-xs-1"></div>
            <div class="col-md-10 col-xs-10">
                <div>
                    <div class="rounded signupForm">
                        <form class="form-signin rounded" method="POST">
                            <div class="formContent rounded">
                                <h1>Sign Up</h1>
                                <div class="form-group">
                                    <input type="text" id="inputUsername" name="usernameField" class="form-control" placeholder="Name"
                                        autocomplete required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="email" id="inputEmail" name="emailField" class="form-control" placeholder="Email address"
                                        autocomplete required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" id="inputPassword1" class="form-control"
                                        placeholder="Password" autocomplete required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" id="inputPassword2" name="passwordField" class="form-control"
                                        placeholder="Re-enter Password" autocomplete required autofocus>
                                </div>
                                <div>
                                    <button type="submit" name="submit" class="btn btn-warning rounded btn-block btnSignup"
                                        onclick="validateSignup(inputUsername, inputEmail, inputPassword1, inputPassword2)"><b>Sign Up</b></button>
                                    <a role="button" href="login.php" class="btn btn-outline-primary rounded btn-block btnSignup"
                                        onclick=""><b>Login</b></a>
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
                </div>
            </div>
            <div class="col-md-1 col-xs-1"></div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="scripts/js/signup.js"></script>
</body>

</html>