<?php
/**
 * controlador para el crud de para,
 */
class tagController  extends Controller{
	/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function index(){
		$this->action_index(new Tag(),true);
    }
	
	/**
	 * metodo accion items que genera miniaturas
	 * @return type
	 */
    function items(){
		$this->action_items(new Tag(),true);
    }
    
    /**
    * metodo accion create que genera el form para agregar registros
    * 
    * @return void
    */
	function create(){
		$this->action_create(new Tag(),$_POST,true);
	}
	/**
	* metdo accion edit que genra el form para editar registros
	* 
	* @return void
	*/
	function edit($id){
		$this->action_edit($id,new Tag(),$_POST,true);
	 }

    /**
	 * metodo accion delete que elimina un registro
	 * @return type
	 */
    public function delete($id){
		$this->action_delete($id,new Tag());
	}
	
}

 
						 
					
					
					
?>