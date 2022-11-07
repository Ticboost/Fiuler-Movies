<?php 
/*****YZX0MAKER <www class="twitter com">@YZX0Long | Fiuler is a old repository of movies site*/
session_start();

use Config\Autoload;
use Config\Request;
use Config\Router;


define('__DS__', DIRECTORY_SEPARATOR);
define('__ROOT__', realpath(dirname(__FILE__)) . __DS__);
define('__URL__', 'https://www.fiuler.com/');
include_once (__ROOT__ . 'Config/Autoload.php');


$loader = Autoload::run();
$request = new Request();
Router::run($request);
