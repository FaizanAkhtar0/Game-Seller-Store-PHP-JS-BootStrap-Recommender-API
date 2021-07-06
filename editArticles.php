<?php
    session_start();

    if (empty($_SESSION['adminUsername'])) {
        echo '<script type="text/JavaScript">  
                location.href = \'/login.php\';
                </script>';
    }

    include "scripts/php/dbConnection.php";
    $article_Ids_json;
    $article_ids = [];
    $articleSelectionFieldData = [];
    $articleRemainingData = [];
    $articleData_json;
    $articleTitles_json;

    function getArticlesAndIDS()
    {
        global $con, $article_ids, $articleSelectionFieldData, $articleRemainingData, $articleData_json, $article_Ids_json, $articleTitles_json;
        $query = "select * from articles";
        $result = mysqli_query($con, $query);
        $counter = 0;
        $article_titles = [];
        while ($row = mysqli_fetch_array($result)) {
            $article_ids[$counter] = $row['article_id'];
            $article_titles[$counter] = $row['article_title'];
            $articleSelectionFieldData[$counter] = $row['article_id'] . "|" . $row['article_title'];
            $articleRemainingData[$counter] = $row['publish_date'] . "|" . $row['article_description'];
            $counter++;
        }
        $articleData_json = json_encode($articleRemainingData);
        $article_Ids_json = json_encode($article_ids);
        $articleTitles_json = json_encode($article_titles);
    }

    function makeDelQuery()
    {
        global $con, $article_ids;
        $id = $_POST['selectionField'];

        if (array_search($id, $article_ids)) {
            $queryDel = "delete from articles where article_id = '$id'";
            if (mysqli_query($con, $queryDel)) {
                echo '<script type="text/JavaScript">  
                        alert("Requested article sucessfuly deleted!");
                        location.href = \'/editArticles.php\';
                        </script>';
            }
        } else {
            echo '<script type="text/JavaScript">  
                    alert("Article does not exist in database!"); 
                    </script>';
        }
    }

    function makeQuery()
    {
        include "scripts/php/insert.php";
        $title = addslashes($_POST['titleField']);
        $articleDate = date_create($_POST['dateField']);
        $date = date_format($articleDate, "d/m/y");
        $articleDescription = addslashes($_POST['descriptionField']);
        $id = $_POST['selectionField'];
        if (empty($_FILES["image"]["tmp_name"])) {
            $insertquery = "update articles set article_title = '$title', publish_date = '$date', article_description = '$articleDescription' where article_id = '$id'";
            global $con;
            if (mysqli_query($con, $insertquery)) {
                echo '<script type="text/JavaScript">  
                    alert("Your Article has been Updated with previous Image!"); 
                    </script>';
            }
        } else {
            $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
            $insertquery = "update articles set article_title = '$title', publish_date = '$date', article_description = '$articleDescription', article_image = '$file' where article_id = '$id'";
            $con = mysqli_connect("localhost", "root", "", "db_motiongaming");
            if (mysqli_query($con, $insertquery)) {
                echo '<script type="text/JavaScript">  
                    alert("Your Article has been Updated!"); 
                    </script>';
            }
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/editArticlesStyles.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Motion Gaming - Edit Article</title>
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
                    <h2>Edit or Delete an article</h2>
                    <div class="input-group mb-3">
                        <?php
                        getArticlesAndIDS();
                        ?>
                        <select class="custom-select" id="articleSelect" name="selectionField" onchange="javascript: fillForm(this);">
                            <option selected>Choose...</option>
                            <?php
                                for ($i = 0; $i < count($articleSelectionFieldData); $i++) {
                                    $tempStr = $articleSelectionFieldData[$i];
                                    $tempArr = explode("|", $tempStr);
                            ?>
                                <option value="<?php echo $tempArr[0] ?>"><?php echo $tempArr[0] . " - " . $tempArr[1] ?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <div class="input-group-append">
                            <label class="input-group-text" for="articleSelect">Select Article</label>
                        </div>
                    </div>
                    <div class="form-group inputBox">
                        <input class="form-control" type="text" id="articleTitle" name="titleField" placeholder="Article Title" required autofocus>
                        <div class="dateInputBox">
                            <label for="publishDate">Date: </label>
                            <input class="form-control" type="date" id="publishDate" name="dateField" placeholder="Date">
                            <label for="image">Select Image: </label>
                            <input class="form-control" type="file" id="imageField" name="image">
                        </div>
                        <div class="inputBox">
                            <textarea class="form-control" rows="5" id="articleDescription" name="descriptionField" placeholder="Discription" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <button type="submit" name="submit" id="submitEditedArticle" class="form-control btn btn-outline-success btn-lg" onclick="verifyInsertionFields(articleTitle, imageField, articleDescription)">Update</button>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <button type="submit" name="submit1" class="form-control btn btn-danger btn-lg" onclick="delArticle()">Delete</button>
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
            document.getElementById('articleDescription').value = "";
            document.getElementById('articleTitle').value = "";
            var index = item.value;
            var formData = JSON.parse('<?= addslashes($articleData_json); ?>');
            var ids = JSON.parse('<?= addslashes($article_Ids_json); ?>');
            var formTitles = JSON.parse('<?= addslashes($articleTitles_json); ?>');
            if (ids.indexOf(index) >= 0) {
                var fieldData_Arr = formData[ids.indexOf(index)];
                var TitleField = formTitles[ids.indexOf(index)];
                var temp_Arr = fieldData_Arr.split("|");
                var dateField = temp_Arr[0];
                var descriptionField = temp_Arr[1];
                document.getElementById('publishDate').innerHTML = Date.parse(dateField);
                document.getElementById('articleDescription').value = descriptionField;
                document.getElementById('articleTitle').value = TitleField;
            } else {
                alert("Article does not exist in the database!");
            }
        }
    </script>

    <script src="scripts/js/articleEdit.js"></script>
</body>

</html>