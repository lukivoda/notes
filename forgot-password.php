<?php
include "config.php";


//Check user inputs
//Define error messages
//Store errors in errors variable
$errors = '';
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
//Get email
if(empty($_POST['forgotemail'])){
    $errors .=$missingEmail;
}elseif(!filter_var($_POST['forgotemail'],FILTER_VALIDATE_EMAIL)){
    $errors .= $invalidEmail;
}else{
    $email = $_POST['forgotemail'];
}



//If there are any errors
if($errors){
    //print error message
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;
}else {//else: No errors
    $db = Db::getConnection();
    $email = $db->quote($email);
    //If the email does not exist
        //print error message
    if(!$user->get("WHERE email = $email")){
       echo "<div class='alert alert-danger'>That email does not exist in our database.</div>";
        //else
            //get the user_id
    }else{
         $row  = $user->get("WHERE email = $email");
         $user_id = $row[0]->user_id;
         $email = $row[0]->email;
          $forgotpassword->user_id = $user_id;
        //Create a unique  activation code
          $key_em = bin2hex(openssl_random_pseudo_bytes(16));
          $forgotpassword->key_em = $key_em;
          $forgotpassword->time = time();
          $forgotpassword->status = 'pending';
        //Insert user details and activation code in the forgotpassword table
          $forgotpassword->save();

         if($forgotpassword->id == $db->lastInsertId()){
             $message = "Please click on this link to reset your password:\n\n";
             $message .= "http://www.stevanris.thecompletewebhosting.com/notes/resetpassword.php?user_id=" . $user_id . "&key_em=$key_em";
             //Send email with link to resetpassword.php with user id and activation code
             if(mail($email, 'Reset Your Password', $message, 'From:'.'stevanris@gmail.com')){
                 echo "<div class='alert alert-success'>An email has been sent to $email.Please click on the link to reset your password.</div>";
             }

         }else{
             echo "<div class='alert alert-danger'>That email does not exist in our database.</div>";
         }

    }







}
?>