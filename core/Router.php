<?php

namespace core;


class Router{
	private $routes;

	public function __construct() {
		$routesPath = ROOT . '/config/routes.php';
		$this->routes = include($routesPath);
	}

	private function getURI() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '  /');
		}
	}
	public function run() {

		$uri = $this->getURI();

		foreach ($this->routes as $uriPattern => $path) {
			if (preg_match("~$uriPattern~", $uri)) {

				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);
				$segments = explode('/', $internalRoute);
				
				$controller = $segments[0];
				$action = $segments[1];

                $controller = 'application\controllers\\' . $controller;
				$controller = new $controller;
				$controller->$action();
			}
		}

	}

}
