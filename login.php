<?php
//Start session
require("config.php");


//Check user inputs
    //Define error messages
    $errors ="";
    $missingEmail = "<p><strong>Please enter yor e-mail.</strong></p>";
    $missingPassword = "<p><strong>Please enter your password.</strong></p>";
    //Get email and password
   if(empty($_POST['loginemail'])){
       $errors .=$missingEmail;
   }else{
       $email = filter_var($_POST['loginemail'],FILTER_SANITIZE_EMAIL);
   }

    if(empty($_POST['loginpassword'])){
        $errors .=$missingPassword;
    }else{
        $password = filter_var($_POST['loginpassword'],FILTER_SANITIZE_STRING);
    }

    //Store errors in errors variable

//If there are any errors
if($errors){
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;
    //if there are no errors
}else {
    $password = hash("sha256", $password);
    $user->email = $email;
    $user->password = $password;
    //Check if combinaton of email & password exists
    if ($user->login()) {
        //calling the get method to get the user object
        $row = $user->get("WHERE email='$user->email' ");
        //store the user credentials in session
        $_SESSION['user_id'] = $row[0]->user_id;
        $_SESSION['username'] = $row[0]->username;
        $_SESSION['email'] = $user->email;
        //if remember me is not checked
        if (empty($_POST["rememberme"])) {
            echo "success";
        }else{

            $user->rememberMe($row[0]->user_id);
            echo "success";
        }


    } else {
        //If email & password don't match print error
        echo "<div class='alert alert-danger'>Your email and password do not match!</div>";
    }

}

?>