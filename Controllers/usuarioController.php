<?php
require_once(ROOT . 'Models/Usuario.php');
require_once(ROOT . 'Models/Nivel_Usuario.php');
class usuarioController extends Controller{
    function index(){
		$this->action_index(new Usuario(),true);
    }
    function create(){
		$this->action_create(new Usuario(),$_POST);
    }
    function edit($id){
		$this->action_edit($id,new Usuario(),$_POST);
    }
    public function delete($id){
		$this->action_delete($id,new Usuario());
	}
}
?>