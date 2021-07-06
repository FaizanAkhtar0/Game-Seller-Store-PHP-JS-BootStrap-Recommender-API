<?php
    session_start();

    include "scripts/php/validateUser.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/login-style.css"/>
    <title>Motion Gaming - Login</title>
</head>

<body>
    <script src="scripts/js/login.js"></script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12"></div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <form class="form-signin rounded" method="POST">
                    <h1 class="h3 mb-3 font-weight-normal fontColorBlack">Please <span style="color: cornsilk;">Sign In</span></h1>
                    <div class="form-group">
                        <input type="email" name="email" id="inputEmail" class="form-control inputBox" placeholder="Email address"
                            autocomplete required autofocus>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="inputPassword" class="form-control inputBox" placeholder="Password"
                            required autofocus>
                    </div>
                    <div class="checkbox pt-2">
                        <label class="fontColorGreen"><input name="admin" type="checkbox" value="Admin"><b> I am admin?</b></label>
                    </div>
                    <button type="submit" name="submit" id="submitUser" class="btn btn-outline-dark loginBtn rounded btn-block"
                        onclick="userValidate(inputEmail, inputPassword);"><b>Login</b></button>
                    <h6 class="error" id="errors"></h6>
                    <div class="invisible">
                            <input type="checkbox" name="uploadStatusField" id="uploadStatus" value="">
                            <input type="hidden" name="uploadVal" id="upload">
                    </div>
                    <?php
                        if (isset($_POST['submit']) && ($_POST['uploadVal'] == '1')){
                            if (isset($_POST['admin'])){
                                $username = @validateAdmin($_POST['email'], $_POST['password']);
                                if (!(is_null($username))){
                                    $_SESSION["adminUsername"] = $username;
                                    echo '<script>alert("A Session has been Created! for: '.$_SESSION["adminUsername"].'");
                                    location.href = \'/AdminIndex.php\';  
                                        </script>';
                                }else{
                                    echo '<script>alert("Invalid Username OR Password for Admin!")</script>';
                                }
                            }else{
                                $username = @validateUser($_POST['email'], $_POST['password']);
                                if (!(is_null($username))){
                                    $_SESSION["username"] = $username;
                                    echo '<script>alert("A Session has been Created! for: '.$_SESSION["username"].'");
                                    location.href = \'/index.php\';  
                                        </script>';
                                }else{
                                    echo '<script>alert("Invalid Username OR Password!")</script>';
                                }
                            }
                        }
                    ?>
                </form>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12"></div>
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
</body>

</html>