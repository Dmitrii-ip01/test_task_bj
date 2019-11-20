<?php

namespace core;

class Controller
{

	public $view;
	public $db;

	function __construct()
	{
		$this->view = new View();
	}

	function index()
	{

	}
	public function preparation($post){
		$post = stripslashes($post);
		$post = htmlspecialchars(trim($post));
		$post = str_replace(["`", "%", "../", "\0"], "", $post);
		return $post;
	}

}
