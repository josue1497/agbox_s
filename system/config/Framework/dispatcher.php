<?php
//namespace App\Config\Framework;
class Dispatcher{
    private $request;
    public function dispatch(){
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();
		
        call_user_func_array(array($controller, 
			$this->request->action), 
			$this->request->params);
    }
    public function loadController(){
        $class_name = $this->request->controller . "Controller";
        $controller = new $class_name();
        return $controller;
    }
}
?>