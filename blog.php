<!-- Connect Require Class -->
<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<!DOCTYPE>
<html>
    <head>
        <title>Blog Page</title>
        <!-- Connect Require Style -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/publicstyles.css">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Inline CSS -->
        <style>
            .col-sm-3{
                background-color: green;
            }
        </style>
    </head>
    <body>
        <!-- Navigation Bar Area -->
        <div style="height: 10px; background: #27aae1;"></div>
        <nav class="navbar navbar-inverse" role="navigation" >
            <div class="container">
                <!-- Navigation Menu Icon Area -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
                            data-target="#collapse">
                        <span class="sr-only">Toggle Navigation</span> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                    </button>
                    <a class="navbar-brand" href="blog.php">
                        <img style="margin-top: -4px;" src="images/web-logo.png" width="100" height="30">
                    </a>
                </div> <!-- Ending of Navigation Menu Icon Area -->
                <!-- Navigation Bar -->
                <div class="collapse navbar-collapse" id="collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="blog.php">Blog</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Service</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Feature</a></li>
                    </ul>
                    <!-- Search Input Field -->
                    <form action="blog.php" class="navbar-form navbar-right">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search" name="Search"/>
                        </div>
                        <!-- Search Button -->
                        <button class="btn btn-default" name="SearchButton">Go</button>
                    </form>
                </div>
            </div>
        </nav> <!-- Ending of Navigation Bar Area -->
        <div class="Line" style="height: 10px; background: #27aae1;"></div>
        <div class="container"> <!-- Container -->
            <div>
                <h1>Welcome To Myanmar Mobile Life Style....</h1>
                <p class="lead">Trust and Belive.Smart and Limited Your Life Style..</p>
            </div>
            <div class="row"><!-- Row -->
                <div class="col-sm-8"> <!-- Main Blog Area -->
                    <?php
                    global $connection;
                    // Check Search Data OR Normal Data
                    if (isset($_GET["SearchButton"])) {
                        $Search = $_GET["Search"];
                        // Query when search Button is active
                        $ViewQuery = "SELECT * FROM adminpanel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
                    } else if (isset($_GET["Page"])) {
                        $Page = $_GET["Page"];
                        if ($Page == 0 || $Page < 1) {
                            $ShowPostFrom = 0;
                        } else {
                            $ShowPostFrom = ($Page * 5) - 5;
                            // Query When Pagination is Active i.e Blog.php?Page=1
                            $ViewQuery = "SELECT * FROM adminpanel ORDER BY datetime desc LIMIT $ShowPostFrom,5";
                        }
                    } else {
                        // The Dafult Query for Blog.php page
                        $ViewQuery = "SELECT * FROM adminpanel ORDER BY datetime desc LIMIT 0,5";
                    }
                    $Execute = mysqli_query($connection, $ViewQuery);
                    while ($DataRows = mysqli_fetch_array($Execute)) {
                        $PostId = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $Title = $DataRows["title"];
                        $Category = $DataRows["category"];
                        $Admin = $DataRows["author"];
                        $Image = $DataRows["image"];
                        $Post = $DataRows["post"];
                        ?>
                        <!-- Blog Item Area -->
                        <div class="blogpost thumbnail">
                            <!-- Image -->
                            <img class="img-responsive img-rounded" src="upload/<?php echo $Image; ?>" >
                            <div class="caption">
                                <!-- Title -->
                                <h1 id="heading"><?php echo htmlentities($Title); ?></h1>
                                <!-- Category and DateTime  -->
                                <p class="description">Category:<?php echo htmlentities($Category); ?> Published on
                                    <?php echo htmlentities($DateTime); ?></p>
                                <!-- Post -->
                                <p class="post"><?php
                                    // Check Post String words
                                    if (strlen($Post) > 150) {
                                        $Post = substr($Post, 0, 150) . '...';
                                    }

                                    echo $Post;
                                    ?></p>
                            </div>
                            <!-- Read More Button -->
                            <a href="fullpost.php?id=<?php echo $PostId; ?>">
                                <span class="btn btn-info">Read More &nbsp;&rsaquo;&rsaquo;</span><br><br>
                            </a>
                        </div> <!-- Ending of Blog Item Area -->

                    <?php } ?>
                    <nav>
                        <ul class="pagination pull-left pagination-lg">
                            <?php
                            global $connection;
                            $QueryPagination = "";
                            $QueryPagination = "SELECT COUNT(*) FROM adminpanel";
                            $ExecutePagination = mysqli_query($connection, $QueryPagination);
                            $RowPagination = mysqli_fetch_array($ExecutePagination);
                            $TotalPosts = array_shift($RowPagination);
                            //echo $TotalPosts;
                            $PostPagination = ceil($TotalPosts / 5);
                            //echo $PostPerPage;

                            for ($i = 1; $i <= $PostPagination; $i++) {
                                if (isset($Page)) {
                                    if ($i == $Page) {
                                        ?>
                                        <li class="active"><a href="blog.php?Page=<?php echo $i; ?>"><?php echo$i; ?></a></li> 
                                        <?php } else {
                                        ?>
                                        <li><a href="blog.php?Page=<?php echo $i; ?>"><?php echo$i; ?></a></li>  
                                        <?php
                                    }
                                }
                            }
                            ?>   
                        </ul>
                    </nav>

                </div> <!-- Main Blog Area Ending -->
                <div class="col-sm-offset-1 col-sm-3"> <!-- Side Area -->
                    <h2>Test</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adispiscing elit
                        , sed do eisusmod tempor incididunt ut labore et dolore magnanimity
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                        ullacmo laboris nisi ut,
                        dent, sunt in culpa qui offica deserunt mollit anim id est laborum.</p>
                </div> <!-- Side Area Ending -->
            </div><!-- Row Ending -->
        </div><!-- Container Ending -->
        <!-- Footer Area -->
        <div id="Footer">
            <hr><p>Theme By | Sapphire | &copy;2017-2020 --- All right reserved.
            </p>
            <a style="color: white; text-decoration: none; cursor: pointer; font-weight:bold;" href="http://Sapphire.com/coupons/" target="_blank">
                <p>
                    This site is only used for Study purpose Sapphire.com have all the rights. no one is allow to distribute
                    copies other then <br>&trade; Sapphire.com &trade;  Udemy ; &trade; Skillshare ; &trade; StackSkills</p><hr>
            </a>

        </div>
        <div style="height: 10px; background: #27AAE1;"></div> 
        <!-- Ending of Footer Area -->
    </body>
</html>