<?php
    function insertIntoDB($query){
        include "dbConnection.php";
        mysqli_query(connectionStatus(), $query);
        return true;
    }


    function updateTheDB($query){
        include "dbConnection.php";
        $result = mysqli_query(connectionStatus(), $query);
        return $result;
    }
?>