<?php
include "config.php";
//get id of notes sent through Ajax call
$note->id = $_POST['id'];
//get the content of the note
$note->note = $_POST['note'];
$note->time =time();

//run a method to update the note
if(!$note->updateNote()){
    echo "error";
}







?>