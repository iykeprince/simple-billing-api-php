<?php
require_once "helpers/biller.php";
class index extends controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $users = $this->model->getUsers();
        
        $biller = Biller::getInstance();
        $biller->setUsers($users);
        $users = $biller->runApi();
        foreach($users as $key => $user){
            echo "$key = username: ".$user['username']." => $".$user['amount_to_bill']."<br>";
        }
    }

 
}
