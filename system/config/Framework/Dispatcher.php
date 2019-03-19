<?php
/**
 * clase que recibe la url parseada y retorna el llamado 
 * al metoo accion del controlador
 */
class Dispatcher{
    private $request;
    /**
     * metodo que genera el llamado al metodo accion del controlador
     *
     * @return type
     */
    public function dispatch(){
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();
		
        call_user_func_array(array($controller, 
			$this->request->action), 
			$this->request->params);
    }
    
    /**
     * metodo que llama al controlador segun la url parseada
     * 
     * @return type
     */
    public function loadController(){
        $class_name = $this->request->controller . "Controller";
        $controller = new $class_name();
        return $controller;
    }
}
?>