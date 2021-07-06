<?php
    header('Content-Type: application/json');
    include "scripts/php/dbConnection.php";

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $Response;

    $statistics = $data['statistics'];

    function makeQuery($query){
        global $con, $Response;
        $result = mysqli_query($con, $query) or die(mysqli_error($con));

        if (!$result){
            $Response = "Couldn't Insert into DB: '" . die(mysqli_error($con)) . "'";
        }
    }

    foreach($statistics as $key => $value){
        $identifier = strval($key);
        $avg_rating = (float)$value['average_rating'];
        $categorical_ratings_count = array();
        foreach($value['category_rating_counts'] as $rat_key => $rat_value){
            $categorical_ratings_count[strval($rat_key)] = (int)$rat_value;
        }
        $neg_rev_count = (int)$value['negative_review_count'];
        $pos_rev_count = (int)$value['positive_review_count'];
        $total_rat_count = (int)$value['total_rating_count'];
        $total_rev_count = (int)$value['total_reviews'];

        $update_query = "update games set total_reviews = " . $total_rev_count . 
        ", positive_review_count = " . $pos_rev_count . 
        ", negative_review_count = " . $neg_rev_count . 
        ", total_rating_count = " . $total_rat_count . 
        ", average_rating = " . $avg_rating . 
        ", rat_count_1 = " . $categorical_ratings_count['1'] . 
        ", rat_count_2 = " . $categorical_ratings_count['2'] . 
        ", rat_count_3 = " . $categorical_ratings_count['3'] . 
        ", rat_count_4 = " . $categorical_ratings_count['4'] . 
        ", rat_count_5 = " . $categorical_ratings_count['5'] . 
        " where game_id = ". (int)$identifier . ";";

        makeQuery($update_query);
    }

    $Response = "Recommendation Process Completed Successfully!";

    var_dump($Response);
?>