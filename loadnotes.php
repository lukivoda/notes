<?php
include "config.php";
//get the user_id from the session
$user_id = $_SESSION['user_id'];

//run a method to delete empty notes
$note->deleteEmptyNotes();

//run a method to look for notes corresponding to user_id
$db= Db::getConnection();
$userId = $db->quote($user_id);
//we are checking if we have any note and executing our method to get notes in the same time
if(!empty($row = $note->get("WHERE user_id = $userId ORDER BY time desc "))){
    foreach($row as $note){
        $time= date("d M, Y H:i:s",$note->time);
     echo "
        <div class='note'>
     <div class='col-xs-3 col-sm-5 delete '><button style='width:100%' class='btn btm-lg btn-danger'>delete</button></div>
    <div class='noteheader' id='$note->id'>
       <div class='text'>$note->note</div>
       <div class='timetext'>$time</div>

        </div>
        </div>";

    }
}else {
   echo  "<div class='alert alert-danger'>You have not created any notes yet!</div>";
}

//show notes or alert message




?>