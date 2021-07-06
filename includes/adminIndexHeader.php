    <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-lg fixed-top">
        <a class="navbar-brand ml-50 p-2" href="adminIndex.php">
            <h2 class="brandIcon"><span style="font-weight:bolder">Motion</span> Gaming</h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Home
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="adminIndex.php">Home(Admin)</a>
                            <a class="dropdown-item" href="index.php" target="_blank">Home(User)</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Articles
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="createArticles.php">Create new articles</a>
                            <a class="dropdown-item" href="editArticles.php">Edit/Delete articles</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Games
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="addGame.php">Add new game</a>
                            <a class="dropdown-item" href="editGame.php">Edit/Delete games</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Games Reviews
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="approveReviews.php">Approve new reviews</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Users
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="manageUsers.php">Manage Users</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Orders
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="manageOrders.php">Manage Orders</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown show bg-dark">
                        <a class="btn btn-dark dropdown-toggle" href="" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Product Recommendation
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropDown">
                            <a class="dropdown-item" href="recommend.php">Open Recommender API</a>
                        </div>
                    </div>
                </li>
                <div class="dropdown show bg-dark">
                    <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="moreDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More
                    </a>
                    <div class="dropdown-menu" aria-labelledby="moreDropDown">
                        <a class="dropdown-item" href="#">Manage Gaming Softwares</a>
                        <a class="dropdown-item" href="#">Manage Boxed Games</a>
                        <a class="dropdown-item" href="#">Manage Product reviews</a>
                    </div>
                </div>
            </ul>

            <form class="form-inline my-2 my-lg-0">
                <div class="dropdown show bg-dark ml-2 mr-5">
                    <?php
                    if (empty($_SESSION['adminUsername'])) {
                    ?>
                        <a role="button" href="login.php" class="btn btn-outline-light my-2 my-sm-0" type="submit">Login</a>
                    <?php
                    } else {
                    ?>
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="UserDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                        echo $_SESSION['adminUsername'];
                    }
                        ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="UserDropDown">
                            <a class="dropdown-item" href="manageProfile.php">Manage Profile</a>
                            <a class="dropdown-item" href="scripts/php/logout.php">Logout</a>
                        </div>
                </div>
            </form>
        </div>
    </nav>