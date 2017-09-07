<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dashboardstyles.css">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2">
                    <h1 style="color: white">Sapphire</h1>
                    <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                        <li><a href="dashboard.php">
                                <span class="glyphicon glyphicon-th"></span>
                                &nbsp;Dashboard</a></li>
                        <li ><a href="addnewpost.php"> <span class="glyphicon glyphicon-list-alt"></span>
                                &nbsp;Add New Post</a></li>               
                        <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>
                                &nbsp;Categories</a></li>
                        <li><a href="#"> <span class="glyphicon glyphicon-user"></span>
                                &nbsp;Manage Admins</a></li>
                        <li class="active"><a href="comment.php"><span class="glyphicon glyphicon-comment"></span>
                                &nbsp;Comments</a></li>
                        <li><a href="#"> <span class="glyphicon glyphicon-equalizer"></span>
                                &nbsp;Live Blog</a></li>
                        <li><a href="#"> <span class="glyphicon glyphicon-log-out"></span>
                                &nbsp;Logout</a></li>
                    </ul>

                </div> <!-- Ending of Side Area -->

                <div class="col-sm-10"> <!-- Main Area -->
                    <div>
                        <?php
                        echo Message();
                        echo SuccessMessage();
                        ?>
                    </div>
                    <h1>Un-Approved Comments</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Approve</th>
                                <th>Delete Comment</th>
                                <th>Details</th>
                            </tr>
                            <?php
                            $connection;
                            $Query = "SELECT * FROM comments WHERE status='OFF' ORDER BY datetime desc";
                            $Execute = mysqli_query($connection, $Query);
                            $serialNo = 0;
                            while ($DataRows = mysqli_fetch_array($Execute)) {
                                $CommentId = $DataRows['id'];
                                $DateTimeofComment = $DataRows['datetime'];
                                $PersonName = $DataRows['name'];
                                $PersonComments = $DataRows['comment'];
                                $CommentPOstId = $DataRows['adminpanel_id'];
                                $serialNo++;
                                 if(strlen($PersonComments)>18){
                                    $PersonComments = substr($PersonComments, 0, 18).'...';
                                }
                                if(strlen($PersonName)>10){
                                    $PersonName = substr($PersonName, 0, 10).'...';
                                }
                                ?>
                                <tr>
                                    <td><?php echo htmlentities($serialNo); ?></td>
                                    <td style="color: #5e5eff;"><?php echo htmlentities($PersonName); ?></td>
                                    <td><?php echo htmlentities($DateTimeofComment); ?></td>
                                    <td><?php echo htmlentities($PersonComments); ?></td>
                                    <td><a href="approveComment.php?id=<?php echo $CommentId; ?>"><span class="btn btn-success">Approve</span></a></td>
                                    <td><a href="deleteComment.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                                    <td><a href="fullpost.php?id=<?php echo $CommentPOstId; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <h1>Approved Comments</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Approved by</th>
                                <th>Revert Approve</th>
                                <th>Delete Comment</th>
                                <th>Details</th>
                            </tr>
                            <?php
                            $connection;
                            $Admin = "Hein Htet";
                            $Query = "SELECT * FROM comments WHERE status='ON' ORDER BY datetime desc";
                            $Execute = mysqli_query($connection, $Query);
                            $serialNo = 0;
                            while ($DataRows = mysqli_fetch_array($Execute)) {
                                $CommentId = $DataRows['id'];
                                $DateTimeofComment = $DataRows['datetime'];
                                $PersonName = $DataRows['name'];
                                $PersonComments = $DataRows['comment'];
                                $CommentPOstId = $DataRows['adminpanel_id'];
                                $serialNo++;
                                if(strlen($PersonComments)>18){
                                    $PersonComments = substr($PersonComments, 0, 18).'...';
                                }
                                if(strlen($PersonName)>10){
                                    $PersonName = substr($PersonName, 0, 10).'...';
                                }
                                ?>
                                <tr>
                                    <td><?php echo htmlentities($serialNo); ?></td>
                                    <td style="color: #5e5eff;"><?php echo htmlentities($PersonName); ?></td>
                                    <td><?php echo htmlentities($DateTimeofComment); ?></td>
                                    <td><?php echo htmlentities($PersonComments); ?></td>
                                    <td><?php echo $Admin; ?></td>
                                    <td><a href="disApproveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-warning">Dis-Approve</span></a></td>
                                    <td><a href="deleteComment.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                                    <td><a href="fullpost.php?id=<?php echo $CommentPOstId; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
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
