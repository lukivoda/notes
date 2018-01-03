<?php


class Note extends Active {


    public $id;
    public $user_id;
    public $note;
    public $time;
    public static $table = 'notes';
    static $key = 'id';

    public static  function deleteEmptyNotes(){
        $db = DB::getConnection();
        try{
            $table = self::$table;
            $deleteEmptyNotesQuery = "DELETE from $table WHERE note = :empty ";
            $statement = $db->prepare($deleteEmptyNotesQuery);
            $statement->execute(array(":empty"=>''));

            if($statement->rowCount()>0 ){
                return true;
            }else{
                return false;
            }

        }catch (PDOException $ex){
            echo "An error occured ".$ex->getMessage();
        }
    }


    public function updateNote() {
        $db = self::getConnection();
        try{
            $updateQuery = "UPDATE notes SET note = :note,time = :time WHERE id = :id";
            $statement = $db->prepare($updateQuery);
            $statement->execute(array(":note" => $this->note, ":time" => $this->time,":id" => $this->id));

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
