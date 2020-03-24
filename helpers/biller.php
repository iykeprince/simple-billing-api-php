<?php
class Biller {
    private $users = [];
    private static $biller = null;


    public static function getInstance(){
        if(self::$biller == null){
            self::$biller = new self();
        }
        return self::$biller;
    }

    public function setUsers($users = []){
        $this->users = $users;
    }

    public function getUsers(){
        return $this->users;
    }

    public function runApi(){
        $users = $this->getUsers();
        return $users;
    }
}