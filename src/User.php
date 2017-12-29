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


}