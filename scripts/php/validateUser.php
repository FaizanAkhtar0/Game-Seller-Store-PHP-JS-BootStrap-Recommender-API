<?php
    include "dbConnection.php";

    function validateAdmin($useremail, $password){
        global $con;
        
        if ($con){
            $querySelect = "select * from admins where email = '$useremail'";
            $result = mysqli_query($con, $querySelect);

            if ($result){
                while($row = mysqli_fetch_array($result)){
                    $hashedPass = $row['password'];
                    if (password_verify($password, $hashedPass)){
                        return $row['admin_name'];
                    }else{
                        echo '<script>alert("Not matched!")</script>';
                        break;
                    }
                }
            }else{
                return null;
            }
        }
    }

    function validateUser($useremail, $password){
        global $con;
        
        if ($con){
            $querySelect = "select * from users where email = '$useremail'";
            $result = mysqli_query($con, $querySelect);

            if ($result){
                while($row = mysqli_fetch_array($result)){
                    $hashedPass = $row['password'];
                    if (password_verify($password, $hashedPass)){
                        return $row['user_name'];
                    }else{
                        echo '<script>alert("Not matched!")</script>';
                        break;
                    }
                }
            }else{
                return null;
            }
        }

    }
?>