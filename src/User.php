<?php

class User extends Active {

    public $user_id;
    public $email;
    public $username;
    public $password;
    public $activation;
    public static $key ="user_id";
    public static  $table ="users";


   public function activate() {
       $db = DB::getConnection();
       try{
           $activateQuery = "UPDATE users SET activation = :activated WHERE email= :email and activation = :activation LIMIT 1";
           $statement = $db->prepare($activateQuery);
           $statement->execute(array(":activated" => 'activated','email'=>$this->email,":activation" => $this->activation));
           if ($statement->rowCount() === 1) {
               return true;
           } else {
               return false;
           }
       }catch (PDOException $ex){
           echo "An error occured ".$ex->getMessage();
       }
   }

    public function login() {
        $db = DB::getConnection();
        try{
            $loginQuery = "SELECT * FROM users WHERE email = :email AND password = :password AND activation = 'activated' LIMIT 1";
            $statement = $db->prepare($loginQuery);
            $statement->execute(array(":email" => $this->email,':password'=>$this->password));
            if ($statement->rowCount() === 1) {
                return true;
            } else {
                return false;
            }
        }catch (PDOException $ex){
            echo "An error occured ".$ex->getMessage();
        }
    }


    public function rememberMe($id){
       $encryptCookieData = base64_encode("mfPv5C1oLjQhEXCM2DfZ123$id");
       //cookie expires in 15 days('/' means that cookie is available in whole domain)
       setcookie('rememberme',$encryptCookieData,time()+15*24*60*60,'/');
    }



    public function isCookieValid(){
       $isValid =  false;

        if(isset($_COOKIE['rememberme'])){

            $decryptCookieData = base64_decode($_COOKIE['rememberme']);
            $user_id = explode("mfPv5C1oLjQhEXCM2DfZ123",$decryptCookieData);
            $userId = $user_id[1];

            if($this->getById($userId)){
                $row = $this->getById($userId);
                $_SESSION['user_id'] = $row->user_id;
                $_SESSION['username'] = $row->username;
                $isValid =true;
            }else{
                $isValid = false;
                $this->logOut();
            }
        }

        return $isValid;

    }




    public function logOut(){
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);

        if(isset($_COOKIE['rememberme'])){
            unset($_COOKIE['rememberme']);
            setcookie('rememberme',null,-1,'/');
        }

        session_destroy();
        session_regenerate_id(true);
        header("Location:index.php");

    }


    public function updatePassword($id){
        $db = DB::getConnection();
        try{
            $updatePasswordQuery = "UPDATE users SET password = :password WHERE user_id =:id";
            $statement = $db->prepare($updatePasswordQuery);
            $statement->execute(array(":password" => $this->password,':id'=>$id));

            if($statement->rowCount()>0 ){
                return true;
            }else{
                return false;
            }

        }catch (PDOException $ex){
            echo "An error occured ".$ex->getMessage();
        }

    }


    public function redirectTo($page){
        header("Location:$page");
    }

}