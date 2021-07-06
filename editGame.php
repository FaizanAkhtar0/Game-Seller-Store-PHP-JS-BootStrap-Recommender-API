<?php
    session_start();

    if (empty($_SESSION['adminUsername'])) {
        echo '<script type="text/JavaScript">  
                location.href = \'/login.php\';
                </script>';
    }

    include "scripts/php/dbConnection.php";
    $game_Ids_json;
    $game_ids = [];
    $gameSelectionFieldData = [];
    $gameRemainingData = [];
    $gameData_json;
    $gameTitles_json;

    function getGamesAndIDS()
    {
        global $con, $game_ids, $gameSelectionFieldData, $gameRemainingData, $gameData_json, $game_Ids_json, $gameTitles_json;
        $query = "select * from games";
        $result = mysqli_query($con, $query);
        $counter = 0;
        $game_titles = [];
        while ($row = mysqli_fetch_array($result)) {
            $game_ids[$counter] = $row['game_id'];
            $game_titles[$counter] = $row['game_name'];
            $gameSelectionFieldData[$counter] = $row['game_id'] . "|" . $row['game_name'];
            $gameRemainingData[$counter] = $row['category'] . "|" . $row['date'] . "|" . $row['description'] . "|" . $row['price'];
            $counter++;
        }
        $gameData_json = json_encode($gameRemainingData);
        $game_Ids_json = json_encode($game_ids);
        $gameTitles_json = json_encode($game_titles);
    }

    function makeDelQuery()
    {
        global $con, $game_ids;
        $id = $_POST['selectionField'];

        if (array_search($id, $game_ids)) {
            $queryDel = "delete from games where game_id = '$id'";
            if (mysqli_query($con, $queryDel)) {
                echo '<script type="text/JavaScript">  
                        alert("Requested game sucessfuly deleted!");
                        location.href = \'/editGames.php\';
                        </script>';
            }
        } else {
            echo '<script type="text/JavaScript">  
                    alert("game does not exist in database!"); 
                    </script>';
        }
    }

    function makeQuery()
    {
        include "scripts/php/insert.php";
        global $con;
        $title = addslashes($_POST['gameTitleField']);
        $gameDate = date_create($_POST['dateField']);
        $date = date_format($gameDate, "d/m/y");
        $price = $_POST['gamePriceField'];
        $category = addslashes($_POST['gameCategoryField']);
        $gameDescription = addslashes($_POST['gameDescriptionField']);
        $id = $_POST['selectionField'];
        if (empty($_FILES["image"]["tmp_name"])) {
            if (empty($_FILES["gameFile"]["tmp_name"])) {
                $updateQuery = "update games set game_name = '$title', category = '$category', date = '$date', description = '$gameDescription', price = '$price' where game_id = '$id'";
                if (mysqli_query($con, $updateQuery)) {
                    echo '<script type="text/JavaScript">  
                        alert("Your game has been Updated with previous Game Files and Image!"); 
                        </script>';
                } else {
                    echo '<script type="text/JavaScript">  
                        alert("Unable to update game with previous Game Files and Image!"); 
                        </script>';
                }
            } else {
                $gameFileName = $_FILES["gameFile"]["name"];
                $target = "uploadedGames/" . basename($gameFileName);
                $updateQuery = "update games set game_name = '$title', category = '$category', date = '$date', description = '$gameDescription', price = '$price', file_name = '$gameFileName' where game_id = '$id'";
                if (mysqli_query($con, $updateQuery)) {
                    if (move_uploaded_file($_FILES['gameFile']['tmp_name'], $target)) {
                        echo '<script type="text/JavaScript">  
                            alert("Your Game has been Updated with new Files and previous Image!"); 
                            </script>';
                    } else {
                        echo '<script type="text/JavaScript">  
                            alert("Unable to update game with new files and previous Image!"); 
                            </script>';
                    }
                } else {
                    echo '<script type="text/JavaScript">  
                            alert("Unable to update Database!"); 
                            </script>';
                }
            }
        } else {
            $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
            if (empty($_FILES["gameFile"]["tmp_name"])) {
                $updateQuery = "update games set game_name = '$title', category = '$category', date = '$date', description = '$gameDescription', price = '$price', image = '$file' where game_id = '$id'";
                if (mysqli_query($con, $updateQuery)) {
                    echo '<script type="text/JavaScript">  
                        alert("Your game has been Updated with previous Game Files and a new Image!"); 
                        </script>';
                } else {
                    echo '<script type="text/JavaScript">  
                        alert("Unable to update game with previous Game Files and a new Image!"); 
                        </script>';
                }
            } else {
                $gameFileName = $_FILES["gameFile"]["name"];
                $target = "uploadedGames/" . basename($gameFileName);
                $updateQuery = "update games set game_name = '$title', category = '$category', date = '$date', description = '$gameDescription', price = '$price', file_name = '$gameFileName', image = '$file' where game_id = '$id'";
                if (mysqli_query($con, $updateQuery)) {
                    if (move_uploaded_file($_FILES['gameFile']['tmp_name'], $target)) {
                        echo '<script type="text/JavaScript">  
                            alert("Your Game has been Updated with new Files and a new Image!"); 
                            </script>';
                    } else {
                        echo '<script type="text/JavaScript">  
                            alert("Unable to update game with new files and a new Image!"); 
                            </script>';
                    }
                } else {
                    echo '<script type="text/JavaScript">  
                            alert("Unable to update Database!"); 
                            </script>';
                }
            }
        }
    }
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
    <title>Motion Gaming - Edit Game</title>
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
                <form class="formArticle rounded" method="POST" enctype="multipart/form-data">
                    <h2>Edit or Delete a Game</h2>
                    <div class="input-group mb-3">
                        <?php
                        getGamesAndIDS();
                        ?>
                        <select class="custom-select" name="selectionField" id="inputGroupSelect01" onchange="fillForm(this)">
                            <option selected>Choose...</option>
                            <?php
                            for ($i = 0; $i < count($gameSelectionFieldData); $i++) {
                                $tempStr = $gameSelectionFieldData[$i];
                                $tempArr = explode("|", $tempStr);
                            ?>
                                <option value="<?php echo $tempArr[0] ?>"><?php echo $tempArr[0] . " - " . $tempArr[1] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="input-group-append">
                            <label class="input-group-text" for="inputGroupSelect01">Select Game</label>
                        </div>
                    </div>
                    <div class="form-group inputBox">
                        <input class="form-control" type="text" name="gameTitleField" id="gameTitle" placeholder="Game Title" required autofocus>
                        <div class="dateInputBox">
                            <label for="gameCategory">Category: </label>
                            <input class="form-control" type="text" name="gameCategoryField" id="gameCategory" placeholder="Game category" required>
                            <label for="gamePrice">Price: </label>
                            <input class="form-control" type="number" step="0.01" name="gamePriceField" id="gamePice" placeholder="Game Price" required>
                            <label for="publishDate">Date: </label>
                            <input class="form-control" type="date" name="dateField" id="gamePublishDate" placeholder="Date" required>
                            <label for="image">Select Image: </label>
                            <input class="form-control" type="file" name="image" id="imageField">
                            <label for="gameField">Select Game File: </label>
                            <input class="form-control" type="file" name="gameFile" id="gameField">
                        </div>
                        <div class="">
                            <textarea class="form-control" rows="5" name="gameDescriptionField" id="gameDescription" placeholder="Discription" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <button type="submit" name="submit" id="submitEditedgame" class="form-control btn btn-outline-success btn-lg" onclick="verifyInsertionFields(gameTitle, gameCategoryField, imageField, gameDescription, gameField)">Update</button>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <button type="submit" name="submit1" class="form-control btn btn-danger btn-lg" onclick="delgame()">Delete</button>
                            </div>
                        </div>
                        <div class="invisible">
                            <input type="checkbox" name="uploadStatusField" id="uploadStatus" value="">
                            <input type="hidden" name="uploadVal" id="upload">
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['submit']) && ($_POST['uploadVal'] == '1')) {
                        makeQuery();
                    }
                    if (isset($_POST['submit1']) && ($_POST['uploadVal'] == '1')) {
                        makeDelQuery();
                    }
                    ?>
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

    <script type="text/javascript">
        function fillForm(item) {
            document.getElementById('gameDescription').value = "";
            document.getElementById('gameTitle').value = "";
            var index = item.value;
            var formData = JSON.parse('<?= addslashes($gameData_json); ?>');
            var ids = JSON.parse('<?= addslashes($game_Ids_json); ?>');
            var formTitles = JSON.parse('<?= addslashes($gameTitles_json); ?>');
            if (ids.indexOf(index) >= 0) {
                var fieldData_Arr = formData[ids.indexOf(index)];
                var TitleField = formTitles[ids.indexOf(index)];
                var temp_Arr = fieldData_Arr.split("|");
                var categoryField = temp_Arr[0];
                var dateField = temp_Arr[1];
                var descriptionField = temp_Arr[2];
                var priceField = temp_Arr[3];
                document.getElementById('gameDescription').value = descriptionField;
                document.getElementById('gameTitle').value = TitleField;
                document.getElementById('gamePice').value = priceField;
                document.getElementById('gameCategory').value = categoryField;
            } else {
                alert("game does not exist in the database!");
            }
        }
    </script>
    <script src="scripts/js/editGame.js"></script>
</body>

</html>