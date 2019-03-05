<?php
class Autoloader {
	public static function app_dirs(){
		return array(
			'system/config/',
			'system/config/Framework/',
			'system/core/',
			'system/',
			'/',
			'',
			'application/models/',
			'application/controllers/',
			'application/views/'
		);
	}
		
	public static function register(){
		spl_autoload_register(function ($class_name) {
			$find=false;
			foreach(Autoloader::app_dirs()  as $dir){
				$class_file = str_replace('\\', DIRECTORY_SEPARATOR, $dir.$class_name).'.php';
				if(is_file($class_file)){
					$find=true;
					require_once ($class_file);
					return true;
				}
			}
			if($find==false){
				throw new Exception('Class not Found: '.$class_name);
			}
		});
	}
}
Autoloader::register();
?>