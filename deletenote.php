<?php
include "config.php";

//get id of notes sent through Ajax call
$id = $_POST["id"];

//run a method to delete the note
if(!$note->delete($id)){
    echo "error";
}






?>