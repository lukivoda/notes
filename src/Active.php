<?php
/*   ACTIVE RECORDS PATTERN    */
/*   ACTIVE RECORDS PATTERN    */
/*   ACTIVE RECORDS PATTERN    */
class Active extends Db
{
    function makeFields() {
        $db = Db::getConnection();
        $fields = "";
        $keyColumn = static::$key;
        foreach ( $this as $fieldKey => $fieldValue) {
            if ($fieldKey == $keyColumn) continue;
            $fields .= $fieldKey . '=' . $db->quote($fieldValue) . ',';
        }
        $fields = rtrim($fields,",");
        return $fields;
    }

    public function update($id) {
        $db = Db::getConnection();
        $tabela = static::$table;
        $key = static::$key;
        //$keyF = static::$key;
        $sql = "UPDATE {$tabela} SET ". $this->makeFields() . " WHERE {$key} = {$id}";
        $db->exec($sql);
    }

    public static function delete($id) {
        $db = Db::getConnection();
        $tabela = static::$table;
        $key = static::$key;
        $db->exec("DELETE FROM {$tabela} WHERE {$key} = {$id}");
    }

    public static function get($filter = "") {
        $db = Db::getConnection();
        $tabela = static::$table;
        $res = $db->query("SELECT * FROM {$tabela} {$filter}");
        $res->setFetchMode(PDO::FETCH_CLASS,get_called_class());
        $output = [];
        while ($rw = $res->fetch()) {
            $output[] = $rw;
        }
        return $output;
    }

    public  function getById($id) {
        $db = Db::getConnection();
        $tabela = static::$table;
        $key = static::$key;
        $res = $db->query("SELECT * FROM {$tabela} WHERE {$key} = {$id}");
        $res->setFetchMode(PDO::FETCH_CLASS,get_called_class());
        return $res->fetch();
    }

    public function save() {
        $db = Db::getConnection();
        $tabela = static::$table;
        $upit = "INSERT INTO {$tabela} SET " . $this->makeFields();
        $db->exec($upit);
        $kljucnaKolona = static::$key;
        $this->$kljucnaKolona = $db->lastInsertId();
        $r = get_object_vars($this);

    }

    public static function getJson($filter = "") {
        $db = Db::getConnection();
        $tabela = static::$table;
        $res = $db->query("SELECT * FROM {$tabela}{$filter}");
        $res->setFetchMode(PDO::FETCH_CLASS,get_called_class());
        $output = [];
        while ($rw = $res->fetch()) {
            $output[] = $rw;
        }
        return json_encode($output);
    }

    public static function getJsonById($id) {
        $db = Db::getConnection();
        $db->query("SET NAMES utf8");
        $tabela = static::$table;
        $key = static::$key;
        $res = $db->query("SELECT * FROM {$tabela} WHERE {$key} = {$id}");
        $output = [];
        while ($rw = $res->fetch(PDO::FETCH_OBJ)) {
            $output[] = $rw;
        }
        return json_encode($output);
    }
}