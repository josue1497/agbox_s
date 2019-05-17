<?php
/**
 * controlador para el crud de source
 */
class date_formatController extends Controller{
	/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function index(){
		$this->action_index(new Date_Format(),true);
    }
    
    /**
	 * metodo accion create que genera el form para agregar registros
	 * 
	 * @return void
	 */
    function create(){
		$this->action_create(new Date_Format(),$_POST,true);
    }
    
    /**
	 * metdo accion edit que genra el form para editar registros
	 * 
	 * @return void
	 */
    function edit($id){
		$this->action_edit($id,new Date_Format(),$_POST,true);
    }

    /**
	 * metodo accion delete que elimina un registro
	 * @return type
	 */
    public function delete($id){
		$this->action_delete($id,new Date_Format());
	}
}
?>