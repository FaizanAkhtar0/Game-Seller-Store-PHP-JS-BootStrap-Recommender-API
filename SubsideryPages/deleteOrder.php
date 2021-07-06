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

    function DeleteOrder(){
        global $id, $con;

        $queryDelete = "delete from orders where order_id = '$id'";

        if (mysqli_query($con, $queryDelete)){
            echo '<script>
                location.href = \'../manageOrders.php\';        
                </script>';
        }else{
            echo '<script>
                    alert("Unable to Delete the selected Order!");
                    location.href = \'../manageOrders.php\';
                  </script>';
        }
    }

    DeleteOrder();
?>