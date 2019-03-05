<?php
/**
 * 
 */
class menuController extends Controller{
	/**
	 * Description
	 * @return type
	 */
    function index(){
		$this->action_index(new Menu(),true);
    }
    
    /**
	 * Description
	 * @return type
	 */
    function create(){
		$this->action_create(new Menu(),$_POST,true);
    }
    
    /**
	 * Description
	 * @return type
	 */
    function edit($id){
		$this->action_edit($id,new Menu(),$_POST,true);
    }

    /**
	 * Description
	 * @return type
	 */
    public function delete($id){
		$this->action_delete($id,new Menu());
	}
}
?>