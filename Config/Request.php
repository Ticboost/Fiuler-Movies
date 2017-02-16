<?php

namespace Config;

class Request {
	
	private $controller;
	private $method;
	private $argument;

	public function getController(){
		return $this->controller;
	}
	public function getMethod(){
		return $this->method;
	}
	public function getArgument(){
		return $this->argument;
	}

	public function setController($controller){
		//var_dump($controller);
		$this->controller = $controller;
	}
	public function setMethod($method){
		$this->method = $method;
	}
	public function setArgument($argument){
		$this->argument = $argument;
	}

	public function __construct() {
		
	if (!empty($_GET['url'])) {
			$route = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
			$route = explode('/', $route);
			$route = array_filter($route);
			
			switch (count($route)) {
				case 1:
					switch ($route[0]) {
						case 'backend':
							if (!empty($_POST['method'])) {
								$this->setController('backend');
								$this->setMethod($_POST['method']);
								if (!empty($_POST['argument'])) {
									$this->setArgument($_POST['argument']);
								}
							}else{
								$this->setController('default');
								$this->setMethod('error404');
							}
							break;

						default:
							$this->setController('default');
							$this->setMethod(strtolower(array_shift($route)));
							break;
					}
					
					break;

				case 2:		
					$this->setController(strtolower(array_shift($route)));
					$this->setMethod(strtolower(array_shift($route)));
					break;

				case 3:
					$this->setController(strtolower(array_shift($route)));
					$this->setMethod(strtolower(array_shift($route)));
					$this->setArgument(strtolower(array_shift($route)));
					break;
			}
						
		}else{

			//print('no se envio ningun parametro<br>');
			$this->setController('default');
			$this->setMethod('index');
		}
	}
}