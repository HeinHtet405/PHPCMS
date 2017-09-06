<!-- Connect Require Class -->
<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
// Click Submit Button
if (isset($_POST["Submit"])) {
    //Get Data Form Input Field and Check String prevent for SQL Injection
    $Title = mysqli_real_escape_string($connection, $_POST["Title"]);
    $Category = mysqli_real_escape_string($connection, $_POST["Category"]);
    $Post = mysqli_real_escape_string($connection, $_POST["Post"]);
    // Date and Time Format
    date_default_timezone_set("Asia/Yangon");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $DateTime;
    // Admin
    $Admin = "Hein Htet";
    // Image Progress
    $Image = $_FILES["Image"]["name"];
    $Target = "upload/" . basename($_FILES["Image"]["name"]);
    // Check Title input data
    if (empty($Title)) {
        $_SESSION["ErrorMessage"] = "Title can't be empty";
        Redirect_to("addnewpost.php");
    } elseif (strlen($Title) < 2) {
        $_SESSION["ErrorMessage"] = "Title Should be at-least 2 Characters";
        Redirect_to("addnewpost.php");
    } else {
        // Save AdminPanel Database
        global $connection;
        $Query = "INSERT INTO adminpanel(datetime,title,category,author,image,post) VALUES('$DateTime','$Title','$Category','$Admin','$Image','$Post')";
        $Execute = mysqli_query($connection, $Query);
        // Image add into project folder
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        // Check for State add data to AdminPanel Database
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Post Added Successfully";
            Redirect_to("addnewpost.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!";
            Redirect_to("addnewpost.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add New Post</title>
        <!-- Connect Require Style -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dashboardstyles.css">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Inline CSS -->
        <style>
            .FieldInfo {
                color: rgb(251,174,44);
                font-family: Bitter,Georgia,"Times New Roman",Times,serif;
                font-size: 1.2em;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Side Menu Area -->
                <div class="col-sm-2">     
                    <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                        <li><a href="dashboard.php">
                                <span class="glyphicon glyphicon-th"></span>
                                &nbsp;Dashboard</a></li>
                        <li class="active"><a href="addnewpost.php"> <span class="glyphicon glyphicon-list-alt"></span>
                                &nbsp;Add New Post</a></li>               
                        <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>
                                &nbsp;Categories</a></li>
                        <li><a href="#"> <span class="glyphicon glyphicon-user"></span>
                                &nbsp;Manage Admins</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-comment"></span>
                                &nbsp;Comments</a></li>
                        <li><a href="#"> <span class="glyphicon glyphicon-equalizer"></span>
                                &nbsp;Live Blog</a></li>
                        <li><a href="#"> <span class="glyphicon glyphicon-log-out"></span>
                                &nbsp;Logout</a></li>
                    </ul>
                </div>
                <!-- Ending of Side Area -->
                <div class="col-sm-10">
                    <h1>Add New Post</h1>
                    <!-- Check Session -->
                    <?php
                    echo Message();
                    echo SuccessMessage();
                    ?> <!-- Ending of Check Session -->
                    <!-- Input Form Area -->
                    <div>
                        <form action="addnewpost.php" method="post" enctype="multipart/form-data"> 
                            <fieldset>
                                <!-- Title Input Field -->
                                <div class="form-group">
                                    <label for="title"><span class="FieldInfo">Title:</span></label>
                                    <input class="form-control" type="text" name="Title" id="title" placeholder="Title"/>
                                </div>
                                <!-- Category Select Area -->
                                <div class="form-group">
                                    <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
                                    <select class="form-control" id="categoryselect" name="Category">

                                        <?php
                                        global $connection;
                                        $ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
                                        $Execute = mysqli_query($connection, $ViewQuery);
                                        while ($DataRows = mysqli_fetch_array($Execute)) {
                                            $Id = $DataRows["id"];
                                            $CategoryName = $DataRows["name"];
                                            ?>
                                            <option><?php echo $CategoryName; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                                <!-- Image Select Area -->
                                <div class="form-group">
                                    <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                                    <input type="File" class="form-control" name="Image" id="imageselect"/>
                                </div>
                                <!-- Post Input Field -->
                                <div class="form-group">
                                    <label for="postarea"><span class="FieldInfo">Post:</span></label>
                                    <textarea class="form-control" name="Post" id="postarea"></textarea>
                                </div>
                                <br>
                                <!-- Submit Button -->
                                <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Post"/>
                            </fieldset>  
                            <br>
                        </form>
                    </div>
                </div> <!-- Ending of Main Area -->
            </div> <!-- Ending of Row -->
        </div> <!-- Ending of Container -->
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
