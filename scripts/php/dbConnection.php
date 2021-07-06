<?php
    $con=mysqli_connect("localhost","root","","db_motiongaming");

    function connectionStatus(){
        global $con;
        if($con) {
            echo '<script type="text/JavaScript">  
            console.log("Database connection sucessful!");
            </script>'; 
        }else{
            echo '<script type="text/JavaScript">  
            alert("Unable to connect with DataBase!") 
            </script>';
        }
        return $con;
    }
?>