<?php 

namespace Config;

class Autoload {

	static function run() {	
		spl_autoload_register(function($class){
					
			$file = str_replace("\\", "/", $class) . ".php";
		
			if (is_readable($file)) {
				//print('require_once ' . $file . '<br>');
				require_once ($file);				
			}
			
		});
	}
}

