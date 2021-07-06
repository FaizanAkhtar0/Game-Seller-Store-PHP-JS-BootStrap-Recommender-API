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

    function DeleteRating(){
        global $id, $con;
        $queryUpdate = "delete from ratings where rating_id = '$id'";

        if (mysqli_query($con, $queryUpdate)){
            echo '<script>
                location.href = \'../approveReviews.php\';        
                </script>';
        }else{
            echo '<script>alert("Unable to delete the selected review!");
            location.href = \'../approveReviews.php\';
            </script>';
        }
    }

    DeleteRating();
?>