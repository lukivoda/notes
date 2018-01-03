<?php
include "config.php";

//get user_id
$user_id = $_SESSION['user_id'];
//get the current time
$time = time();
//run a method to create new note
$note->user_id =$user_id;
$note->time= $time;
$note->note = '';
$note->save();
echo $note->id;



?>