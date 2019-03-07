<?php
class userController extends Controller{
    function index(){
		$this->action_index(new User(),true);
    }
    function create(){
		$this->action_create(new User(),$_POST,true);
    }
    function edit($id){
		$this->action_edit($id,new User(),$_POST,true);
    }
    public function delete($id){
		$this->action_delete($id,new User());
	}
}
?>