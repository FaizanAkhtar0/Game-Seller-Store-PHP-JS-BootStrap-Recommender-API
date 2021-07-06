<footer class="footerStyle page-footer indigo pt-4">
    <div class="container-fluid text-center text-md-left">
        <div class="row">
            <div class="col-md-6 mt-md-0 mt-3">
                <h5 class="">Organizational Moto</h5>
                <p class="brandIcon" style="font-size: 2rem;">Life it self is a game. <br>And<br> "It is said that the ending of every game is decided at the very beginning of it's first step towards initiation".</p>
            </div>
            <hr class="clearfix w-100 d-md-none pb-3">
            <div class="col-md-3 mb-md-0 mb-3">
                <h5 class="text-uppercase">Articles</h5>

                <ul class="list-unstyled">
                    <?php
                    $gameNameSelect = "select game_name from games";
                    $gameFetchResult = mysqli_query($con, $gameNameSelect);

                    while ($gRow = mysqli_fetch_array($gameFetchResult)) {
                        $nameOfGame = $gRow['game_name'];
                    ?>
                        <li>
                            <a href="viewArticles.php"><?php echo $nameOfGame ?></a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-3 mb-md-0 mb-3">
                <h5 class="text-uppercase">Game Reviews</h5>
                <ul class="list-unstyled">
                    <?php
                    $rating = 4;
                    $status = true;
                    $counter = 0;
                    $queryGame = "select game_id from ratings where rated_value >= '$rating' AND approved_status = '$status'";
                    $latestGameData = mysqli_query($con, $queryGame);

                    while ($row = mysqli_fetch_array($latestGameData)) {
                        if ($counter >= 25){
                            break;
                        }else{
                            $counter++;
                        }
                        $gameID = $row['game_id'];
                        $queryGameName = "select game_name from games where game_id = '$gameID'";
                        $resultGameName = mysqli_query($con, $queryGameName);
                        while ($nRow = mysqli_fetch_array($resultGameName)) {
                            $name = $nRow['game_name'];
                    ?>
                            <li>
                                <a href="viewReviews.php"><?php echo $name ?></a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright text-center py-3 endFooterStyle">&reg 2019 All Rights Reserved:
        <a href="#">@UnKnowN.com</a>
        <div class="mr-5" style="float: right;">
            <a target="_blank" href="https://www.facebook.com/Unknown.c0m000" class="fab fa-facebook-f fa-circle mr-3"></a>
            <a href="#" class="fab fa-google-plus-g fa-circle mr-3"></a>
            <a href="#" class="fab fa-linkedin-in fa-circle mr-3"></a>
            <a target="_blank" href="https://stackoverflow.com/users/11614440/alex-davidson" class="fab fa-stack-overflow"></a>
        </div>
    </div>
</footer>