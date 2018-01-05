<?php
//Start session and connecting to database
include "config.php";

//get user_id

//Get username sent through Ajax call
$user->username = $_POST['username'];

//run a method to update the username
if(!$user->updateUsername($_SESSION['user_id'])){
    echo "error";
}

