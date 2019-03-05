<?php
class menuController extends Controller{
    function index(){
		$this->action_index(new Menu(),true);
    }
    function create(){
		$this->action_create(new Menu(),$_POST,true);
    }
    function edit($id){
		$this->action_edit($id,new Menu(),$_POST,true);
    }
    public function delete($id){
		$this->action_delete($id,new Menu());
	}
}
?>