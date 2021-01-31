<?php

class admins
{
	private $db;

	public function __construct()
	{
		$this->db = new database;
	}
	
	public function login($username, $pass)
	{
		$this->db->query('SELECT * from users WHERE Username=? AND Password=? AND GroupID = 1');
		$arr = $this->db->resultOne(array($username, $pass));
		if($this->db->rowCount() == 1)
			return $arr;
		return -1;
	}
    
}