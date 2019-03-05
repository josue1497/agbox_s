<?php
class permissionController extends Controller{
    function index(){
		$this->action_index(new Permission(),true);
    }
    function create(){
		$this->action_create(new Permission(),$_POST,true);
    }
    function edit($id){
		$this->action_edit($id,new Permission(),$_POST,true);
    }
    public function delete($id){
		$this->action_delete($id,new Permission());
	}
}
?>