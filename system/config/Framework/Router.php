<?php
/**
 * clase que parsea la url y genera informacion de controlador, 
 * metodo accion y parametros 
 */
class Router{
	/**
	 * obtiene la url y la peticion y genera un objeto parseado
	 *
	 * @param type $url 
	 * @param type $request 
	 * @return type
	 */
    static public function parse($url, $request){
        $url = trim($url);
		$explode_url = explode('/', $url);
		$real_controller='';
		$controller = 'index';
		$real_action='';
		$action = 'index';
		$real_param=array();
		$param = array();
		
		if(count($explode_url)>2){
			$explode_url = array_slice($explode_url, 2);
			if(isset($explode_url[0]) && !empty($explode_url[0])){
				$controller = $explode_url[0] ;
				$real_controller = $controller ;
			}
			
			//no deberia pasar por aqui
			if($controller=='')
				$controller='index';
			
			if(isset($explode_url[1]) && !empty($explode_url[1])){
				$action = $explode_url[1] ;
				$real_action = $action ;
			}
			
			//no deberia pasar por aqui
			if($action=='')
				$action='index';
		}
		if(count($explode_url)>2){
			$param = array_slice($explode_url, 2);
			$real_param = $param;
		}
		
		if(!Session::check('logged_in')){
			$controller = 'index';
			$action = 'login';
		}
		
		$request->real_controller = $real_controller;
		$request->controller = $controller;
		$request->real_action = $real_action;
		$request->action = $action;
		$request->params = $param;
		$request->real_params = $real_param;
    }
}
?>