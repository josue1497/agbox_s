<?php
class user_LevelController extends Controller{
    function index(){
		$this->action_index(new User_Level(),true);
    }
    function create(){
		$this->action_create(new User_Level(),$_POST,true);
    }
    function edit($id){
		$this->action_edit($id,new User_Level(),$_POST,true);
    }
    public function delete($id){
		$this->action_delete($id,new User_Level());
	}
}
?>