<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
if(isset($_GET['id'])){
    $IdFromURL = $_GET["id"];
    $connection;
    $Query = "DELETE FROM comments WHERE id='$IdFromURL'";
    $Execute = mysqli_query($connection, $Query);
    if($Execute){
        $_SESSION["SuccessMessage"] = "Comment Deleted Successfully";
        Redirect_to("comment.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!";
        Redirect_to("comment.php");
    }
}
