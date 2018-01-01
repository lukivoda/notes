<!--This file receives: user_id, generated key to reset password, password1 and password2-->
<!--This file then resets password for user_id if all checks are correct-->
<?php
include "config.php";
//If user_id or key is missing
if(!isset($_POST['user_id'])  && !isset($_POST['key_em'])){
    echo '<div class="alert alert-danger">There was an error. Please try again.</div>';
    //else
}else {
        //Store them in two variables
        $user_id = $_POST['user_id'];
        $key_em = $_POST['key_em'];
        $time_d = time() - 86400;
        $db = Db::getConnection();
        $user_id = $db->quote($user_id);
        $key_em = $db->quote($key_em);
        $time_d = $db->quote($time_d);
        //Check combination of user_id & key exists and less than 24h old
    if(!empty($forgotpassword->get("WHERE user_id = $user_id and key_em = $key_em and time > $time_d and status= 'pending' "))) {
        $errors ='';
        $missingPassword = '<p><strong>Please enter a Password!</strong></p>';
        $invalidPassword = '<p><strong>Your password should be at least 6 characters long and inlcude one capital letter and one number!</strong></p>';
        $differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
        $missingPassword2 = '<p><strong>Please confirm your password</strong></p>';

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
            //Update users password in the users table
            $password = hash('sha256',$password);
            $user->password = $password;
            $id = $_POST['user_id'];
            if($user->updatePassword($id)){
                //set the key status to "used" in the forgotpassword table to prevent the key from being used twice
                $forgotpassword->status = 'used';
                $forgotpassword->key_em = $_POST['key_em'];
                $id = $_POST['user_id'];
                $forgotpassword->updateStatus($id);

                echo "<div class='alert alert-success'>Password updated successfully <a href='index.php'> Login</a></div>";
            }else{
                echo "<div class='alert alert-danger'>There was a problem storing the new password in the database!</div>";
            }

            }


    }else{
        echo "<div class='alert alert-danger'>Please try again.</div>";
    }

}


?>