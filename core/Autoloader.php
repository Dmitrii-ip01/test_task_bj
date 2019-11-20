<?php

namespace core;

class Autoloader {

	public function __construct()
	{
		$this->load_classes();

	}

	public function load_classes(){
		spl_autoload_register(static function ($class_name) {
			$class_name = str_replace('\\', '/', $class_name);
            $app = dirname(__DIR__, 1);
            $path = $app . DIRECTORY_SEPARATOR . $class_name . '.php';
			print_r( $path);
            if (file_exists($path)) {
                include_once $path;
				
            }
           
            
		});
	}
}


