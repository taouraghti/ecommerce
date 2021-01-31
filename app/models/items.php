<?php

class items
{
	private $db;

	public function __construct()
	{
		$this->db = new database;
	}
	
	public function getAll()
	{
		$this->db->query("SELECT items.*, categories.Name AS CatName, users.Username 
							FROM items 
							INNER JOIN categories ON items.CatID = categories.ID
							INNER JOIN users ON items.UserID = users.UserID
							ORDER BY ItemID DESC");
        return $this->db->resultArray();
	}

	public function countItem()
	{
		$this->db->query("SELECT ItemId FROM items");
		return $this->db->rowCount();
	}

	public function getLatest($limit=5)
	{
		$this->db->query("SELECT * FROM items ORDER BY ItemId DESC LIMIT $limit");
		return $this->db->resultArray();
	}

}
