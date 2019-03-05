<?php
define('ROOT', str_replace("index.php", "", $_SERVER["SCRIPT_FILENAME"]));
define('WEBROOT', str_replace("index.php", "", $_SERVER["SCRIPT_NAME"]));
require_once(ROOT.'system/core/Application.php');
//namespace App;
/* constantes de la app */


require_once(ROOT.'system/core/Autoloader.php');

//use App\Config\Core;
//use App\Config\Framework\Router;
//use App\Config\Framework\Request;
//use App\Config\Framework\Dispatcher;

	//require(ROOT . 'Config/core.php');

	session_start();

	$dispatch = new Dispatcher();
	$dispatch->dispatch();

?>