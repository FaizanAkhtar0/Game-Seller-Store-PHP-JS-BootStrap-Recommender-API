<?php
    session_start();
    
    if (empty($_SESSION['adminUsername'])){
        echo '<script type="text/JavaScript">  
            location.href = \'/login.php\';
            </script>';
    }


    include "scripts/php/dbConnection.php";

    $json_identifiers;
    $json_reviews;
    $json_ratings;

    function makeQuery(){
        global $con, $json_identifiers, $json_reviews, $json_ratings, $schemas;
        $db_name = $schemas[addslashes($_POST['dbSelectionField'])];
        $table_name = addslashes($_POST['tableSelectionField']);
        $identifier_col = addslashes($_POST['identifierField']);
        $review_col = addslashes($_POST['reviewField']);
        $rating_col = addslashes($_POST['ratingField']);
        $selectQuery = "select " .$identifier_col. ", " .$review_col. ", " .$rating_col. " from " .$db_name. "." .$table_name. ";";
        $identifiers = [];
        $reviews = [];
        $ratings = [];

        $result = mysqli_query($con, $selectQuery) or die(mysqli_error($con));
        $new_counter = 0;
        while ($row = mysqli_fetch_array($result)){
            $identifiers[$new_counter] = $row[0];
            $reviews[$new_counter] = $row[1];
            $ratings[$new_counter] = $row[2];
            $new_counter++;
        }

        $json_identifiers = json_encode($identifiers);
        $json_reviews = json_encode($reviews);
        $json_ratings = json_encode($ratings);
        echo '<script>alert("Data has been collected from database and is ready to be sent!")</script>';

        $response = array('identifier' => $identifiers, 'review' => $reviews, 'rating' => $ratings);
        $fp = fopen('data.json', 'w');
        fwrite($fp, json_encode($response));
        fclose($fp);
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                                <h3>Use Recommender API</h3>
                                <div class="form-group">
                                    <?php
                                        $query = "show SCHEMAS;";
                                        $result = mysqli_query($con, $query);
                                        $schemas = [];
                                    ?>
                                    <select class="custom-select" name="dbSelectionField" id="DBSelect", onchange="javascript: filltables(this);">
                                        <option value="-1"><--Select Database--></option>
                                        <?php
                                            $counter = 0;
                                            while ($row = mysqli_fetch_array($result)) {
                                                $schemas[$counter] = $row[0];
                                        ?>
                                        <option value="<?php echo $counter ?>"><?php echo $row[0] ?></option>
                                        <?php 
                                                $counter++;
                                            }
                                            $counter = 0;
                                        ?>
                                    </select>
                                </div>
                                <?php

                                    $tables = [];
                                    for ($i = 0; $i < count($schemas); $i++){
                                        $query = "show TABLES from $schemas[$i]";
                                        $result = mysqli_query($con, $query);
                                        $temp = "";
                                        while ($row = mysqli_fetch_array($result)){
                                            $temp .= $row[0] . '|';
                                        }
                                        $tables[$i] = $temp;
                                    }
                                    $json_tables = json_encode($tables);
                                ?>
                                <div class="form-group">
                                    <select class="custom-select" name="tableSelectionField" id="tableSelect">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="identifierCol" name="identifierField" class="form-control"
                                        placeholder="Identifier Column Name" autocomplete required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="reviewCol" name="reviewField" class="form-control"
                                        placeholder="Review Column Name" autocomplete required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="ratingCol" name="ratingField" class="form-control"
                                        placeholder="Rating Column Name" autocomplete required autofocus>
                                </div>
                                <div class="row ml-2">
                                    <div class="col-md-5">
                                        <button type="submit" name="submit" class="btn btn-info rounded btn-block btnSignup p-2"
                                        onclick="validatetypedFields(identifierCol, reviewCol, ratingCol)"><b>Collect Data</b></button>
                                    </div>
                                    <div class="col-md-5">
                                        <button type="button" name="Lsubmit" id="process_api_call" class="btn btn-warning rounded btn-block btnSignup p-2"
                                        onclick="call_api()"><b>Start Process</b></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div id="progressSpinner" class="spinner-border text-success ml-5 mt-1" style="visibility:hidden;" aria-hidden="true"></div>
                                    </div>
                                    <div class="col-md-3"></div>
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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function readJsonFile(file, callback) {
            var rawFile = new XMLHttpRequest();
            rawFile.overrideMimeType("application/json");
            rawFile.open("GET", file, true);
            rawFile.onreadystatechange = function() {
                if (rawFile.readyState === 4 && rawFile.status == "200") {
                    callback(rawFile.responseText);
                }
            }
            rawFile.send(null);
        }

        function handle_json_response(data){
            $.ajax({
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                type: "POST",
                url: "handleResponse.php",
                dataType: "json",
                data: JSON.stringify(data),
                async: true,
                success: function(response){
                    alert(response);
                },
                error: function(error){
                    console.log(error);
                }
            })
            document.getElementById('progressSpinner').style.visibility = "hidden";
        }

        //usage:
        function call_api(){
            document.getElementById('progressSpinner').style.visibility = "visible";
            readJsonFile("data.json", function(text){
                var data = JSON.parse(text);
                console.log(data);
                send_data(data);
            });
        }

        function send_data(data){
            $.ajax({
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                type: "POST",
                crossDomain: true,
                data: JSON.stringify(data),
                dataType: "json",
                async: true,
                url: "http://localhost:5000/recommender",
                success: function(response){
                    handle_json_response(response);
                },
                error: function (error) {
                    console.log(error);
                }
            })
        }
        
        function filltables(field){ 
            var sel = document.getElementById('tableSelect');
            for (i = sel.length - 1; i >= 0; i--) {
                sel.remove(i);
            }

            var tables = JSON.parse('<?= addslashes($json_tables) ?>');
            var index = field.value;
            if(index != '-1'){
                var temp = tables[index];
                temp = temp.split('|');
                for (var i = 0; i < temp.length; i++){
                    if (temp[i] != ''){
                        var option = document.createElement('option');
                        option.value = temp[i];
                        option.innerHTML = temp[i];

                        var element = document.getElementById('tableSelect');
                        element.appendChild(option);
                    }
                }
            }
        }


        var uploadFlag = false;

        function validatetypedFields(identifierCol, reviewCol, ratingCol){
            var id = identifierCol.value;
            var rev = reviewCol.value;
            var rat = ratingCol.value;

            if (id == ''){
                return;
            }else{
                uploadFlag = true;
            }

            if (rev == ''){
                uploadFlag = false;
                return;
            }else{
                uploadFlag = true;
            }

            if (rat == ''){
                uploadFlag = false;
                return;
            }else{
                uploadFlag = true;
            }

            if (uploadFlag){
                document.getElementById("upload").value = 1;
                document.getElementById("uploadStatus").checked = true;
            }else{
                return;
            }
        }
    </script>
</body>

</html>