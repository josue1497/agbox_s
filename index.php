<?php
define('ROOT', str_replace("index.php", "", $_SERVER["SCRIPT_FILENAME"]));
define('WEBROOT', str_replace("index.php", "", $_SERVER["SCRIPT_NAME"]));

require_once(ROOT.'system/core/Application.php');
//require_once(ROOT.'system/config/Framework/Dispatcher.php');

session_start();

$dispatch = new Dispatcher();
$dispatch->dispatch();
?>