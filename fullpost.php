<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
// Click Submit Button
if (isset($_POST["Submit"])) {
    //Get Data Form Input Field and Check String prevent for SQL Injection
    $Name = mysqli_real_escape_string($connection, $_POST["Name"]);
    $Email = mysqli_real_escape_string($connection, $_POST["Email"]);
    $Comment = mysqli_real_escape_string($connection, $_POST["Comment"]);
    // Date and Time Format
    date_default_timezone_set("Asia/Yangon");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $DateTime;
    $PostId = $_GET["id"];
    // Check input data
    if (empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION["ErrorMessage"] = "All Fields are required";
    } elseif (strlen($Comment) > 500) {
        $_SESSION["ErrorMessage"] = "Comment Should be 500 Characters";
    } else {
        // Save AdminPanel Database
        global $connection;
        $PostIdFromURL = $_GET['id'];
        $Query = "INSERT into comments (datetime,name,email,comment,status,adminpanel_id) VALUES('$DateTime','$Name','$Email','$Comment','OFF','$PostIdFromURL')";
        $Execute = mysqli_query($connection, $Query);
        // Check for State add data to AdminPanel Database
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Comment Submitted Successfully";
            Redirect_to("fullpost.php?id={$PostId}");
        } else {
            $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!";
            Redirect_to("fullpost.php?id={$PostId}");
        }
    }
}
?>
<!DOCTYPE>
<html>
    <head>
        <title>Full Blog Post</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/publicstyles.css">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <style>
            .col-sm-3{
                background-color: green;
            }
            .FieldInfo {
                color: rgb(251,174,44);
                font-family: Bitter,Georgia,"Times New Roman",Times,serif;
                font-size: 1.2em;
            }
            .CommentBlock {
                background-color: #F6F7F9;
            }
            .Comment-info{
                color: #365899;
                font-family: sans-serif;
                font-size: 1.1em;
                font-weight: bold;
                padding-top: 10px;
            }
            .comment {
                margin-top: -2px;
                padding-bottom: 10px;
                font-size: 1.1em;
            }
        </style>
    </head>
    <body>
        <div style="height: 10px; background: #27aae1;"></div>
        <nav class="navbar navbar-inverse" role="navigation" >
            <div class="container">
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
                </div>
                <div class="collapse navbar-collapse" id="collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="blog.php">Blog</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Service</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Feature</a></li>
                    </ul>
                    <form action="blog.php" class="navbar-form navbar-right">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search" name="Search"/>
                        </div>
                        <button class="btn btn-default" name="SearchButton">Go</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="Line" style="height: 10px; background: #27aae1;"></div>
        <div class="container"> <!-- Container -->
            <div>
                <h1>Welcome To My Shoe City....</h1>
                <p class="lead">All product are Made in Italy.Smart and Limited Your Style..</p>
            </div>
            <div class="row"><!-- Row -->
                <div class="col-sm-8"> <!-- Main Blog Area -->
                    <!-- Check Session -->
                    <?php
                    echo Message();
                    echo SuccessMessage();
                    ?> <!-- Ending of Check Session -->
                    <?php
                    global $connection;
                    if (isset($_GET["SearchButton"])) {
                        $Search = $_GET["Search"];
                        $ViewQuery = "SELECT * FROM adminpanel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
                    } else {
                        $PostIDFromURL = $_GET["id"];
                        $ViewQuery = "SELECT * FROM adminpanel WHERE id='$PostIDFromURL' ORDER BY datetime desc";
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
                        <div class="blogpost thumbnail">
                            <img class="img-responsive img-rounded" src="upload/<?php echo $Image; ?>" >
                            <div class="caption">
                                <h1 id="heading"><?php echo htmlentities($Title); ?></h1>
                                <p class="description">Category:<?php echo htmlentities($Category); ?> Published on
                                    <?php echo htmlentities($DateTime); ?></p>
                                <p class="post"><?php echo $Post; ?></p>
                            </div>
                        </div>

                    <?php } ?>
                    <br>
                    <span class="FieldInfo">Share your thoughts about this post</span>
                    <br>
                    <span class="FieldInfo">Comments</span>
                    <?php
                    $connection;
                    $PostIdForComments = $_GET["id"];
                    $ExtractCommentQuery = "SELECT * FROM comments WHERE adminpanel_id='$PostIdForComments' AND status='ON'";
                    $Execute = mysqli_query($connection, $ExtractCommentQuery);
                    while ($DataRows = mysqli_fetch_array($Execute)) {
                        $CommentDate = $DataRows["datetime"];
                        $CommentName = $DataRows["name"];
                        $CommentbyUsers = $DataRows["comment"];
                        ?> 
                        <div class="CommentBlock">
                            <img style="margin-left: 10px; margin-top: 10px;" class="pull-left" src="images/comment.png" width="70px" height="70px">
                            <p style="margin-left: 90px;" class="Comment-info" ><?php echo $CommentName; ?></p>
                            <p style="margin-left: 90px;" class="description"><?php echo $CommentDate; ?></p>
                            <p style="margin-left: 90px;" class="comment"><?php echo $CommentbyUsers; ?></p>
                        </div>
                        <br>
                        <hr>
                    <?php } ?>
                    <!-- Comment Form Area -->
                    <div>
                        <form action="fullpost.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data"> 
                            <fieldset>
                                <!-- Name Input Field -->
                                <div class="form-group">
                                    <label for="Name"><span class="FieldInfo">Name:</span></label>
                                    <input class="form-control" type="text" name="Name" id="Name" placeholder="Name"/>
                                </div>
                                <!-- Email Input Field -->
                                <div class="form-group">
                                    <label for="Email"><span class="FieldInfo">Email:</span></label>
                                    <input class="form-control" type="email" name="Email" id="Email" placeholder="Email"/>
                                </div>
                                <!-- Post Input Field -->
                                <div class="form-group">
                                    <label for="commentarea"><span class="FieldInfo">Comment:</span></label>
                                    <textarea class="form-control" name="Comment" id="commentarea"></textarea>
                                </div>
                                <br>
                                <!-- Submit Button -->
                                <input class="btn btn-primary" type="Submit" name="Submit" value="Submit"/>
                            </fieldset>  
                            <br>
                        </form>
                    </div> <!-- Ending of Comment Form Area -->
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
    </body>
</html>