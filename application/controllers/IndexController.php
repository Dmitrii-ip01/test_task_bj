<?php

namespace application\controllers;

use core\Controller;

use application\models\Task;

class IndexController extends Controller

{
	private $errors = [];

	public function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$model_task = new Task();
		$data = [];
		if (isset($_POST['submit'])) {

			$name  = $this->preparation($_POST['name']);
			$email = $this->preparation($_POST['email']);
			$task  = $this->preparation($_POST['task']);

			if ($model_task->isEmpty($name)) {
				$this->errors[] = 'Поле "Имя" обязательно для заполнения';
			}

			if ($model_task->isEmpty($email)) {
				$this->errors[] = 'Поле "Email" обязательно для заполнения';
			} else {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$this->errors[] = 'Поле "Email" некорректный';
				}
			}

			if ($model_task->isEmpty($task)) {
				$this->errors[] = 'Поле "Задача" обязательно для заполнения';
			}

			if (!count($this->errors)) {
				if ($model_task->addTask($name, $email, $task)) {
					setcookie('success', true);
					$this->redirect();
				} else {
					$this->errors[] = 'Ошибка добавления';
				}
			}

		}


		if (isset($_GET['name'])) {

			$getSort  = $this->preparation($_GET['name']);
			$getParam = 'name';

		} elseif (isset($_GET['status'])) {

			$getSort  = $this->preparation($_GET['status']);
			$getParam = 'status';

		} elseif (isset($_GET['email'])) {

			$getSort  = $this->preparation($_GET['email']);
			$getParam = 'email';

		} else {

			$getSort = false;
			$getParam = false;
		}
		if (isset($_GET['page'])) {

			$page = $_GET['page'];

		} else {

			$page = 1;

		}

		$pages          = 3;
		$entry_on_page  = 3;
		$max_pages_list = 5;
		$data['tasks']  = $model_task->getTasks($page, $getSort, $getParam, $pages);
		$data['page']   = $model_task->Pagination($page, $getSort, $getParam, $entry_on_page, $max_pages_list);
		$data['active_link'] = $page;

		if (AdminController::isAdmin()) {
			$data['admin'] = true;
		}

		if (isset($_COOKIE['success']) && $_COOKIE['success']) {
			$data['success'] = true;
			setcookie('success', false);
		}
		$data['errors'] = $this->errors;

		$data['action'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['title'] = 'Задачи';
		if (isset($data['admin'])) {
			$data['button_login'] = '<button class="btn btn-light"><a href="/admin/logout" class="text-primary">Выйти</a></button>';
		} else {
			$data['button_login'] = '<button class="btn btn-light"><a href="admin/login" class="text-primary">Aвторизация</a>
					</button>';
		}

		$this->view->generate('common/header.php', $data);
		$this->view->generate('index/index.php', $data);

	}

	public function actionUpdateTask()
	{
		$model_task = new Task();

		if (AdminController::isAdmin()) {
			if (isset($_POST)) {

				$id   = $this->preparation($_POST['id']);
				$task = $this->preparation($_POST['task']);

				if (!$model_task->isEmpty($task)) {
					$model_task->updateText($id, $task);
				}
			}
			echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
		} else {
			echo json_encode(['success' => false], JSON_UNESCAPED_UNICODE);
		}

	}

	public function actionUpdateStatus()
	{
		echo'1';
		 print_r($_POST);
		$model_task = new Task();

		if (AdminController::isAdmin()) {
			if (isset($_POST)) {
				$id     = $this -> preparation($_POST['id']);
				$status = $this -> preparation($_POST['status']);
				$model_task -> updateStatus($id, $status);
			}
		} else {
			echo json_encode(['success' => false], JSON_UNESCAPED_UNICODE);
		}
	}

	private function redirect()
	{
		header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	}


}
