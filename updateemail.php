<?php
require "config.php";

//get user_id and new email sent through Ajax
$user_id = $_SESSION['user_id'];
$newEmail = $_POST['email'];
$db = Db::getConnection();

//check if new email exists
if(!empty($user->get("WHERE email = $newEmail "))){
  echo "<div class='alert alert-danger'>That email already exists in our database!Please choose another email!</div>";
}else{
    //get the current email of our user
    $currentEmail = $_SESSION['email'];
    //create a unique activation code
    $activation_key2 = bin2hex(openssl_random_pseudo_bytes(16));
    //insert our new unique activation code in our users table
    $user->user_id =$user_id;
    $user->activation2 = $activation_key2;
   if(!$user->updateAcivationCode2()){
       echo "<div class='alert alert-danger'>We have a problem updating your email.Please try again!</div>";
   }else{
       //send email with link with current email,new email and activation code to activatenewemail.php
       $message = "Please click on this link to prove that you own this email:\n\n";
       $message .= "http://www.stevanris.thecompletewebhosting.com/notes/activatenewemail.php?email=" . urlencode($currentEmail) ."&newemail=".urlencode($newEmail). "&key=$activation_key2";
       //Send the user an email with a link to activate.php with their email and activation code
       if(mail($newEmail, 'Email update for Notes app', $message, 'From:'.'stevanris@gmail.com@')){
           echo "<div class='alert alert-success'> A confirmation email has been sent to $newEmail. Please click on the activation link to update your email!.</div>";
       }else{
           echo "<div class='alert alert-danger'> We have problem sending you the confirmation email to $newEmail.Try with another email.</div>";
       }
   }

}







