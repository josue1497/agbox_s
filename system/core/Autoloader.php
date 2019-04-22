<?php
/**
 * clase que genera la carga automatica de dependencias. 
 * si las cases a cargar estan en un arhivo con su mismo nombre, 
 * y en las ubicaciones indicadas en el metodo app_dirs,
 * no se necesitaran require o includes para poder instanciarlas.
 */
class Autoloader {
	/**
	 * metodo estatico que devuelve un array con los nombres de los 
	 * directorios a incluir en la carga automatica.
	 *
	 * @return array de strings
	 */
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
			'application/views/',
			'application/views/Layouts/lan/'

		);
	}
	/**
	 * metodo estatico que mediante la funcion spl_autoload_register de php y 
	 * haciendo uso de un metodo anonimo, registra todas las rutas devueltas por el 
	 * metodo app_dirs en la carga automatica de la aplicacion, 
	 *
	 * 
	 * de modo que si se intenta instanciar una clase en cualquier nivel de la aplicacion,
	 * se buscaran en todas las rutas indicadas, y de existir el archivo con dicha 
	 * clase, se incluira mediante un require_once y luego se instanciara el objeto 
	 * de dicha clase.
	 *
	 * @return boolean
	 * @throws Exception mensaje de clase no encontrada
	 */
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
				//if not found may be is not in this routs
			}
		});
	}
}
?>