<?php
// Redirect Another Page Function
function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit();
}

