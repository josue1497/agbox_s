<?php
/**
 * controlador para el crud de para,
 */
class paramController  extends Controller{
	/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function index(){
		$this->action_index(new Param(),true);
    }
	
	/**
	 * metodo accion items que genera miniaturas
	 * @return type
	 */
    function items(){
		$this->action_items(new Param(),true);
    }
    
    /**
    * metodo accion create que genera el form para agregar registros
    * 
    * @return void
    */
	function create(){
		$this->action_create(new Param(),$_POST,true);
	}
	/**
	* metdo accion edit que genra el form para editar registros
	* 
	* @return void
	*/
	function edit($id){
		$this->action_edit($id,new Param(),$_POST,true);
	 }

    /**
	 * metodo accion delete que elimina un registro
	 * @return type
	 */
    public function delete($id){
		$this->action_delete($id,new Param());
	}
	
}

 
						 
					
					
					
?>