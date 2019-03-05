<?php
class nivel_usuarioController extends Controller{
    function index(){
		$this->action_index(new Nivel_Usuario(),true);
    }
    function create(){
		$this->action_create(new Nivel_Usuario(),$_POST,true);
    }
    function edit($id){
		$this->action_edit($id,new Nivel_Usuario(),$_POST,true);
    }
    public function delete($id){
		$this->action_delete($id,new Nivel_Usuario());
	}
}
?>