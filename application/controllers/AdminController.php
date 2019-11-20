<?php

namespace application\controllers;

use application\models\Admin;
use core\Controller;

class AdminController extends Controller
{

	private $errors = [];

	public function __construct()
	{
		parent::__construct();

	}

	public function actionLogin()
	{
		$admin_model = new Admin();

		if ($this->isAdmin()) {
			header('Location: /');
		}

		if (isset($_POST['submit'])) {
			$name     = $this->preparation($_POST['name']);
			$password = $this->preparation($_POST['password']);

			if ($admin_model->isEmpty($name)) {
				$this->errors[] = 'Поле "Имя" обязательно для заполнения';
			}

			if ($admin_model->isEmpty($password)) {
				$this->errors[] = 'Поле "Пароль" обязательно для заполнения';
			}

			if (!count($this->errors)) {

				$userId = $admin_model->checkUserData($name, $password);

				if ($userId) {
					$_SESSION['admin'] = $userId;
					header('Location: /');
				} else {
					$this->errors[] = 'Неправильные данные для входа на сайт';
				}
			}
			$data['name'] = $name;
		}
		$data['errors']       = $this->errors;
		$data['title']        = 'Админ панель';
		$data['button_login'] = '';

		$this->view->generate('common/header.php',$data);
		$this->view->generate('admin/index.php', $data);
	}

	public static function actionLogout()
	{
		if (isset($_SESSION['admin'])) {
			unset($_SESSION['admin']);
			session_destroy();
		}
        header('Location: /');
	}

	public static function isAdmin()
	{
		if (isset($_SESSION['admin'])) {
			return true;
		}
	}

}
