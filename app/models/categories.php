<?php

class categories
{
	private $db;

	public function __construct()
	{
		$this->db = new database;
	}
	
    public function getAll()
    {
        $this->db->query("SELECT * FROM categories");
        return $this->db->resultArray();
    }
    
}