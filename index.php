<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
define('ROOT', __DIR__);
session_start();
require_once(ROOT.'/core/Autoloader.php');
$autoload = new core\Autoloader();

$router = new core\Router();
$router->run();
