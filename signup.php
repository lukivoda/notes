<?php
//<!--Start session-->
require("config.php");
//Connect to the database

//<!--Check user inputs-->
    // <!--Define error messages-->
$errors= "";
$missingUsername = '<p><strong>Please enter a username!</strong></p>';
$invalidUsername = '<p><strong>Username must be at least 6 characters long,but not more than 14!</strong></p>';
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
$missingPassword = '<p><strong>Please enter a Password!</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and inlcude one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';
//    <!--Get username, email, password, password2-->
    //Get username
  if(empty($_POST['username'])  ){
      $errors .=$missingUsername;
  }elseif(strlen($_POST['username'])<6 || strlen($_POST['username']>14)){
      $errors .= $invalidUsername;
  }else {
      $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
  }

    if(empty($_POST['email'])){
    $errors .=$missingEmail;
    }elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
    $errors .= $invalidEmail;
    }else{
       $email = $_POST['email'];
    }

if(empty($_POST['password'])){
    $errors .=$missingPassword;
}else if(!preg_match("#.*^(?=.{6,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#",$_POST['password'])){
        $errors .= $invalidPassword;
}else{
   $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    if(empty($_POST['password2'])){
        $errors .=$missingPassword2 ;
    }else {
        $password2 = filter_var($_POST['password2'],FILTER_SANITIZE_STRING);
        if($password != $password2){
            $errors .= $differentPassword;
        }
    }
}

//if there are errors
if($errors){
   $resultMessage = "<div class='alert alert-danger'>$errors</div>";
   echo $resultMessage;
    //if there are no errors
}else {
    $user = new User();
    //checking if we have same username in the database
    if (!empty($user->get(" where username = '$username' "))) {
        echo "<div class='alert alert-danger'>That username is already taken.</div>";
        //checking if we have same email in the database
    } elseif (!empty($user->get(" where email = '$email' "))) {
        echo "<div class='alert alert-danger'>That email is already taken.</div>";
    } else {
        $activation_key = bin2hex(openssl_random_pseudo_bytes(16));
        $user->username = $username;
        $user->email = $email;
        $password = hash('sha256',$password);
        $user->password = $password;
        $user->activation = $activation_key;

        $user->save();

        $message = "Please click on this link to activate your account:\n\n";
        $message .= "http://www.stevanris.thecompletewebhosting.com/notes/activate.php?email=" . urlencode($email) . "&key=$activation_key";
        //Send the user an email with a link to activate.php with their email and activation code
        if(mail($email, 'Confirm your Registration', $message, 'From:'.'stevanris@gmail.com')){
            echo "<div class='alert alert-success'>Thank for your registering! A confirmation email has been sent to $email. Please click on the activation link to activate your account.</div>";
        }


    }
}

?>