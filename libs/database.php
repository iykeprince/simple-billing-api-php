<?php

class Database extends PDO{
    private static $connection = null;

    public function __construct() {
        try{
            parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf-8'");
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public static function getInstance(){
        if(self::$connection == null){
            self::$connection = new self();
        }
        return self::$connection;
    }
    /**
     * SELECT
     * QUERY
     * HELPERS
     */
    public function getRowCounts($sql){
        try{
            $query = $this->prepare($sql);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $count = $query->rowCount();
            return $count;
        }catch(PDOException $e){ return $e->getMessage(); }

    }
    public function getAssoc($sql){
         try{
            $query = $this->prepare($sql);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            return $query->fetchAll();
        }catch(PDOException $e){ return $e->getMessage(); }
    }
    public function getItem($sql){
        try{
            $query = $this->prepare($sql);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            return $query->fetch();
        }catch(PDOException $e){ return $e->getMessage(); }
    }
    public function getCount($sql){
        try{
            $query = $this->prepare($sql);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $count = $query->rowCount();
            if( $this->hasCount($count) ){
                return $this->getItem($sql);
            }else{
                return 0;
            }
        }catch(PDOException $e){ return $e->getMessage(); }
    }
    private function hasCount($count){
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }
    /*
    insert
    @param string $table a name of table to insert into
    @param array $data 
    */
    public function insert($table, $data){
        ksort($data);
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':'.implode(', :', array_keys($data));
        $sth = $this->prepare("INSERT INTO $table(`$fieldNames`) VALUES($fieldValues)");
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        $sth->execute();
        return $this->lastInsertId();
    }

    public function update($table, $data, $where){
        ksort($data);
        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ",");

        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        $sth->execute();
    }
    public function delete($table, $where){
        $sth = $this->prepare("DELETE FROM $table WHERE $where");
        $sth->execute();
    }
}