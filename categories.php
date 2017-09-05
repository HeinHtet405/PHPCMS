<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
if (isset($_POST["Submit"])) {
    $Category = mysqli_real_escape_string($connection, $_POST["Category"]);
    date_default_timezone_set("Asia/Yangon");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $DateTime;
    $Admin = "Hein Htet";
    if (empty($Category)) {
        $_SESSION["ErrorMessage"] = "All Fields must be filled out";
        Redirect_to("dashboard.php");
    } elseif (strlen($Category) > 99) {
        $_SESSION["ErrorMessage"] = "Too long Name for Category";
        Redirect_to("Categories.php");
    } else {
        global $connection;
        $Query = "INSERT INTO category(datetime,name,creatorname) VALUES('$DateTime','$Category','$Admin')";
        $Execute = mysqli_query($connection, $Query);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Category Added Successfully";
            Redirect_to("categories.php");
        } else {
            $_SESSION["ErrorMessage"] = "Category failed to Add";
            Redirect_to("categories.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Categories</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/adminstyles.css">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
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
                <div class="col-sm-2">
                  
                    <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                        <li><a href="dashboard.php">
                                <span class="glyphicon glyphicon-th"></span>
                                &nbsp;Dashboard</a></li>
                        <li><a href="addnewpost.php"> <span class="glyphicon glyphicon-list-alt"></span>
                                &nbsp;Add New Post</a></li>               
                        <li class="active"><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>
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

                </div> <!-- Ending of Side Area -->
                <div class="col-sm-10">
                    <h1>Manage Categories</h1>
                    <?php
                    echo Message();
                    echo SuccessMessage();
                    ?>
                    <div>
                        <form action="categories.php" method="post"> 
                            <fieldset>
                                <div class="form-group">
                                    <label for="categoryname"><span class="FieldInfo">Name:</span></label>
                                    <input class="form-control" type="text" name="Category" id="categoryname" placeholder="Name"/>
                                </div>
                                <br>
                                <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Post"/>
                            </fieldset>  
                            <br>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Serial No.</th>
                                <th>Date & Time</th>
                                <th>Category Name</th>
                                <th>Creator Name</th>
                            </tr>
                            <?php
                            global $connection;
                            $ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
                            $Execute = mysqli_query($connection, $ViewQuery);
                            $serialNo=0;
                            while ($DataRows = mysqli_fetch_array($Execute)) {
                                $Id = $DataRows["id"];
                                $DateTime = $DataRows["datetime"];
                                $CategoryName = $DataRows["name"];
                                $CreatorName = $DataRows["creatorname"];
                                $serialNo++;
                            
                            ?>
                            <tr>
                                <td><?php echo $serialNo; ?></td>
                                <td><?php echo $DateTime; ?></td>
                                <td><?php echo $CategoryName; ?></td>
                                <td><?php echo $CreatorName; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div> <!-- Ending of Main Area -->
            </div> <!-- Ending of Row -->
        </div> <!-- Ending of Container -->
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
