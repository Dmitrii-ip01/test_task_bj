<?php

namespace application\models;

use core\Db;

class Task extends Db
{

	public $allPages = '';

	function __construct()
	{
		$dbcon = new Db();
		$this->db = $dbcon->getConnection();
		$this->allPages = $this->Page();
	}


	public function getTasks($page, $sort, $params, $pages)
	{
		if ($page > ceil($this->allPages / 3)) {
			$page = ceil($this->allPages / 3);
		}
		if ($page == 1) {
			$page = 0;
		} else {
			$page = ($page - 1) * $pages;
		}
		$sql = ("SELECT * FROM tasks ");

		if ($params) {
			$sql .= ("ORDER BY " . $params . " " . $sort);
		}

		if ($this->allPages > $pages) {
			$sql .= " LIMIT :page,$pages";
		}

		$result = $this->db->prepare($sql);
		$result->bindParam(':page', $page, \PDO::PARAM_INT);
		$result->execute();

		return $result->fetchAll(\PDO::FETCH_ASSOC);

	}

	public function addTask($name, $email, $task)
	{
		$status = 0;
		$edit = 0;
		$sql = ('INSERT INTO tasks SET name = :name, task = :task, email = :email, status =:status, edit = :edit');
		$result = $this->db->prepare($sql);
		$result->bindParam(':name', $name, \PDO::PARAM_STR);
		$result->bindParam(':task', $task, \PDO::PARAM_STR);
		$result->bindParam(':email', $email, \PDO::PARAM_STR);
		$result->bindParam(':status', $status, \PDO::PARAM_INT);
		$result->bindParam(':edit', $edit, \PDO::PARAM_INT);

		return $result->execute();

	}

	public function Pagination($page, $sort, $params,$entry_on_page,$max_pages_list )
	{
		$all = $this->allPages;
		$current_page = $page;
		$arrPag = [];
		$count_pages = ceil($all / $entry_on_page);
		$first_page = $current_page - (int)($max_pages_list / 2);
		if ($first_page <= 1) {
			$first_page = 1;
		} else {
			if ($count_pages - $first_page < $max_pages_list) {
				$first_page = $count_pages - $max_pages_list + 1;
				if ($first_page <= 1) {
					$first_page = 1;
				}
			}
		}
		
		$last_page = $first_page + $max_pages_list - 1;

		if ($last_page > $count_pages) {
			$last_page = $count_pages;
		}
		if ($params == false || $sort == false) {
			for ($i = $first_page; $i <= $last_page; $i++) {
				$arrPag[$i]['link'] = '/?page=' . $i;
				$arrPag[$i]['num'] = $i;
			}
		} else {
			for ($i = $first_page; $i <= $last_page; $i++) {
				$arrPag[$i]['link'] = '/?page=' . $i . '&' . $params . '=' . $sort;
				$arrPag[$i]['num'] = $i;
			}
		}
		if(count($arrPag)==$max_pages_list){
			$arrPag[] = [
				'link' => '/?page='.	$count_pages,
				'num' => $count_pages
			];
		}
		if($first_page > 1){
			$first = [
				'link' => '/?page=1',
				'num' => 1
			];
		array_unshift($arrPag, $first);
		}
		return $arrPag;

	}

	public function Page()
	{
		$sql = ("SELECT COUNT(*) FROM tasks");
		$result = $this->db->query($sql);
		$count = $result->fetch(\PDO::FETCH_NUM);
		$count = $count[0];

		return $count;
	}

	public function updateStatus($id, $status)
	{

		$sql = ('UPDATE tasks SET status = :status WHERE id = :id');

		$result = $this->db->prepare($sql);
		$result->bindParam(':id', $id, \PDO::PARAM_INT);
		$result->bindParam(':status', $status, \PDO::PARAM_INT);
		$result->execute();

		return $result;

	}

	public function updateText($id, $task)
	{

		$edit = 1;

		$sql = ('UPDATE tasks SET task = :task, edit = :edit WHERE id = :id');

		$result = $this->db->prepare($sql);
		$result->bindParam(':id', $id, \PDO::PARAM_INT);
		$result->bindParam(':task', $task, \PDO::PARAM_STR);
		$result->bindParam(':edit', $edit, \PDO::PARAM_INT);

		$result->execute();

		return $result;

	}

	public function isEmpty($field)
	{
		return strlen($field) <= 1;
	}

}
