<?php
require("config.php");
////0
//:
//{name: "currentpassword", value: "Stevan12"}
//1
//:
//{name: "password", value: "Stevan1"}
//2
//:
//{name: "password2", value: "Stevan1"}

//Check user inputs
//Define error messages
$errors ="";
$missingCurrentPassword = '<p><strong>Please enter your current password!</strong></p>';

$wrongCurrentPassword = '<p><strong>Your current password is wrong!</strong></p>';
$missingNewPassword1 ='<p><strong>Please enter your new password!</strong></p>';
$invalidPassword = '<p><strong>Your new password should be at least 6 characters long and inlcude one capital letter and one number!</strong></p>';
$missingNewPassword2 = '<p><strong>Please confirm your new password</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';

//get the current password
  $currentPassword = $_POST["currentpassword"];
//get new password1
  $newPassword1 = $_POST["password"];
//get new password2
  $newPassword2 = $_POST["password2"];

//Validate the password inputs
if(empty($currentPassword)){
    $errors .=$missingCurrentPassword;
}else {
    $currentPassword = hash('sha256',$currentPassword);
    if(empty($user->get("WHERE password = '$currentPassword' "))) {
        $errors .=$wrongCurrentPassword;
    }elseif(empty($newPassword1)){
        $errors .= $missingNewPassword1;
    }elseif(!preg_match("#.*^(?=.{6,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#",$newPassword1)){
        $errors .= $invalidPassword;
    }else {
        $newPassword1  = filter_var($newPassword1,FILTER_SANITIZE_STRING);
        if(empty($newPassword2)){
            $errors .= $missingNewPassword2;
        }else{
            $newPassword2 = filter_var($newPassword2,FILTER_SANITIZE_STRING);

            if($newPassword1 != $newPassword2) {
                $errors .= $differentPassword;
            }
        }
    }


}

if($errors){
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;
}else{
    $user_id = $_SESSION['user_id'];
    $user->password = hash('sha256',$newPassword1);
    if(!$user->updatePassword($user_id)){
        echo "<div class='alert alert-danger'>Your password is not updated!Please try again!</div>";
    }else{
        echo "<div class='alert alert-success'>Your password is updated!Please <a class='btn btn-success' href='index.php?logout=1'>log in</a> with your new password</div>";
    }
}





//else if(!preg_match("#.*^(?=.{6,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#",$_POST['password'])){
//    $errors .= $invalidPassword;
//}else{
//    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
//    if(empty($_POST['password2'])){
//        $errors .=$missingPassword2 ;
//    }else {
//        $password2 = filter_var($_POST['password2'],FILTER_SANITIZE_STRING);
//        if($password != $password2){
//            $errors .= $differentPassword;
//        }
//    }
//}