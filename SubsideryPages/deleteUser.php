<?php
    session_start();
    include "../scripts/php/dbConnection.php";
    $id;
    if(empty($_REQUEST['id'])){
        if (!(empty($_SESSION['adminUsername']))){
            echo '<script>
                location.href = \'../adminIndex.php\';        
                </script>';
        }else{
            echo '<script>
                location.href = \'../login.php\';        
                </script>';
        }
    }else{
        $tempID = $_REQUEST['id'];
        $id = base64_decode($tempID);
    }

    function DeleteUser(){
        global $id, $con;

        $queryDelete = "delete from users where user_id = '$id'";

        if (mysqli_query($con, $queryDelete)){
            echo '<script>
                location.href = \'../manageUsers.php\';        
                </script>';
        }else{
            echo '<script>alert("Unable to delete the selected user!");
            location.href = \'../manageUsers.php\'; 
            </script>';
        }
    }

    DeleteUser();
?>