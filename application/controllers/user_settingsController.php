<?php
class user_settingsController extends Controller{
    function index(){
		$this->action_index(new User_Settings(),true);
    }
    function create(){
		$this->action_create(new User_Settings(),$_POST,true);
    }
    function edit($id){
		$this->action_edit($id,new User_Settings(),$_POST,true);
    }
    public function delete($id){
		$this->action_delete($id,new User_Settings());
	}
}
?>