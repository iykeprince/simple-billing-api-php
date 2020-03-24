<?php
class index_model extends model{
    public function __construct(){
        parent::__construct();
    }

    public function getUsers(){
        $query = "SELECT * FROM users"; 
        $result = $this->db->getAssoc($query);
        return $result;
    }
}