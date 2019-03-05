<?php
class permisoController extends Controller{
    function index(){
		$this->action_index(new Permiso(),true);
    }
    function create(){
		$this->action_create(new Permiso(),$_POST,true);
    }
    function edit($id){
		$this->action_edit($id,new Permiso(),$_POST,true);
    }
    public function delete($id){
		$this->action_delete($id,new Permiso());
	}
}
?>