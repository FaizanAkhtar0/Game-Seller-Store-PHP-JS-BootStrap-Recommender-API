<?php
    session_start();
    
    if (empty($_SESSION['adminUsername'])){
        echo '<script type="text/JavaScript">  
            location.href = \'/login.php\';
            </script>';
    }

    include "scripts/php/dbConnection.php";
    @connectionStatus(); // '@' for hiding any warning shown on the body of page.

    function makeQuery(){
        global $con;
        $title = addslashes($_POST['articleTitleField']);
        $articleDate = date("d/m/y", time()); // gets the day, date, month, year, time, AM or PM
        $articleDescription = addslashes($_POST['articleDescriptionField']);  
        $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));

        $insertquery = "insert into articles(article_title, publish_date, article_description, article_image) values('$title','$articleDate','$articleDescription','$file')";
        if (mysqli_query($con, $insertquery)){
            echo '<script type="text/JavaScript">  
            alert("Your Article has been published!"); 
            </script>';
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
    <link rel="stylesheet" href="css/articlesCreationStyle.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Motion Gaming - Create Article</title>
</head>

<body>
    <script src="scripts/js/createArticleInsertion.js"></script>
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
                    <div class="form-group inputBox">
                        <Label>Write a new article</Label>
                        <input class="form-control" type="text" name="articleTitleField" id="articleTitle" placeholder="Game Title" required autofocus>
                        <div class="dateInputBox">
                            <label for="publishDate">Date: (automated Insertion)</label>
                            <label for="image">Select Image: </label>
                            <input class="form-control" name="image" type="file" id="imageField" >
                        </div>
                        <div class="">
                            <textarea class="form-control" rows="5" name="articleDescriptionField" id="articleDescription" placeholder="Description" ></textarea>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="form-control btn btn-success" name="submit" id="submitArticle"
                            onclick="verifyInsertionFields(articleTitle, imageField, articleDescription)">Publish</button>
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

    
</body>

</html>