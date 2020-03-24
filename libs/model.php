<?php
class Model{
	public function __construct(){
		$this->db = Database::getInstance();
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}