<?php
class bills extends controller
{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $bill = isset($_GET['bill']) ? $_GET['bill'] : 0.00;
        echo "You acccount has been charge ".$bill."<br>";
    }
}