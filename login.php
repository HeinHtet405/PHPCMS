<!-- Connect Require Class -->
<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
// Click Submit Button
if (isset($_POST["Submit"])) {
    //Get Data Form Input Field and Check String prevent for SQL Injection
    $UserName = mysqli_real_escape_string($connection, $_POST["Username"]);
    $Password = mysqli_real_escape_string($connection, $_POST["Password"]);
    // Check Category input data
    if (empty($UserName) || empty($Password)) {
        $_SESSION["ErrorMessage"] = "All Fields must be filled out";
        Redirect_to("login.php");
    } else {
        $Found_Account = Login_Attempt($UserName, $Password);
        $_SESSION["User_Id"] = $Found_Account["id"];
        $_SESSION["Username"] = $Found_Account["username"];
        if ($Found_Account) {
            $_SESSION["SuccessMessage"] = "Login Successfull {$_SESSION["Username"]}";
            Redirect_to("dashboard.php");
        } else {
            $_SESSION["ErrorMessage"] = "Invalid Username and Password";
            Redirect_to("login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin</title>
        <!-- Connect Require Style -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dashboardstyles.css">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Inline CSS -->
        <style>
            .FieldInfo {
                color: rgb(0, 134, 179);
                font-family: Bitter,Georgia,"Times New Roman",Times,serif;
                font-size: 1.2em;
            }
            body{
                background-image:url("images/body-background.jpg");
                background-repeat: no-repeat;
                background-size: 100% 100%;
            }
            html {
                height: 100%;
            }
            h1{
                text-align: center;
                color: rgb(0, 134, 179);
                font-family: Bitter,Georgia,"Times New Roman",Times,serif;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
                    <br><br><br><br>
                    <h1>Registration</h1>
                    <!-- Check Session -->
                    <?php
                    echo Message();
                    echo SuccessMessage();
                    ?> <!-- Ending of Check Session -->
                    <!-- Input Form Area --> 
                    <div>
                        <form action="login.php" method="post"> 
                            <fieldset>
                                <!-- UserName Input Field -->
                                <div class="form-group">
                                    <label for="Username"><span class="FieldInfo">UserName:</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-envelope text-primary" ></span>
                                        </span>
                                        <input class="form-control" type="text" name="Username" id="Username" placeholder="Username"/>
                                    </div>
                                </div>
                                <!-- Password Input Field -->
                                <div class="form-group">
                                    <label for="Password"><span class="FieldInfo">Password:</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-lock text-primary" ></span>
                                        </span>
                                        <input class="form-control" type="Password" name="Password" id="Password" placeholder="Password"/>
                                    </div>
                                </div>
                                <br>
                                <!-- Submit Button -->
                                <input class="btn btn-info btn-block" type="Submit" name="Submit" value="Login"/>
                            </fieldset>  
                            <br>
                        </form>
                    </div>
                </div> <!-- Ending of Main Area -->
            </div> <!-- Ending of Row -->
        </div> <!-- Ending of Container -->
    </body>
</html>
