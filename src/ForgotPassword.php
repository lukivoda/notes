<?php

class ForgotPassword extends Active {
    public $id;
    public $user_id;
    public $key_em;
    public $time;
    public $status;
    public static $key ="id";
    public static  $table ="forgotpassword";
    public function updateStatus($id){
        $db = DB::getConnection();
        try{
            $updateStatusQuery = "UPDATE forgotpassword SET status = :status WHERE key_em = :key_em and user_id = :id ";
            $statement = $db->prepare($updateStatusQuery);
            $statement->execute(array(":status" => $this->status,':key_em'=>$this->key_em,":id" => $id));
        }catch (PDOException $ex){
            echo "An error occured ".$ex->getMessage();
        }
    }
}
