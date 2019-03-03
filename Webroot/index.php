<?php

define('WEBROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

require(ROOT . 'Config/core.php');

session_start();

function base_url(){
	$r = new Request();
	Router::parse($r->url, $r);
	$url='';
	
	if($r->real_controller!='' && $r->real_action!=''){
		$url.='../';
	}
	
	if($r->real_action!='' && count($r->real_params)>0){
		$url.='../';
	}
	return $url;
}

$dispatch = new Dispatcher();
$dispatch->dispatch();

?>