<?php

class comments
{
	private $db;

	public function __construct()
	{
		$this->db = new database;
	}
	
	public function getAll()
	{
		$this->db->query("SELECT *, users.Username , items.Name as ItemName
						FROM comments
						INNER JOIN users ON users.UserId=comments.UserId
						INNER JOIN items ON items.ItemId=comments.ItemId
						ORDER BY CommentId DESC");
        return $this->db->resultArray();
	}

	public function countComment()
	{
		$this->db->query("SELECT CommentId FROM comments");
		return $this->db->rowCount();
	}

	public function getLatest($limit=5)
	{
		$this->db->query("SELECT *, users.Username 
							FROM comments
							INNER JOIN users ON users.UserId=Comments.UserId
							ORDER BY CommentId DESC LIMIT $limit");
		return $this->db->resultArray();
	}

}
