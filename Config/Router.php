<?php 
namespace Config;

class Router{
	public static function run(Request $request) {

		$controller = ucfirst($request->getController()) . "Controller";
		$route = __ROOT__ . "Controllers" . __DS__ . $controller .".php";
		$method = $request->getMethod();

		$argument = $request->getArgument();
		
		if(is_readable($route)){
			//print('require_once ' . $route . '<br>');
			require_once($route);
			$class_controller = "Controllers\\" . $controller;
			$object = new $class_controller;

			if(empty($argument)){
				//var_dump(array($object, $method));
				$data = call_user_func(array($object, $method));
			}else{
				//var_dump(array($object, $method, $argument));
				$data = call_user_func_array(array($object, $method), array($argument));
			}
		}
	
	}
}
