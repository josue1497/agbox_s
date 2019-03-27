<?php
/**
 * controlador para el crud de menu
 */
class noteController extends Controller{
	/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function index(){
		$this->action_index(new Note(),true);
    }
    
    /**
	 * metodo accion create que genera el form para agregar registros
	 * 
	 * @return void
	 */
    function create(){
		$this->action_create(new Note(),$_POST,true);
    }
    
    /**
	 * metdo accion edit que genra el form para editar registros
	 * 
	 * @return void
	 */
    function edit($id){
		$this->action_edit($id,new Note(),$_POST,true);
    }

    /**
	 * metodo accion delete que elimina un registro
	 * @return type
	 */
    public function delete($id){
		$this->action_delete($id,new Note());
	}
	
	public function note_information($id){
		$this->init(new Note());
		$d["record"] = $this->model->get_by_id($id);

		$this->set($d);
		$this->render('note_information');
	}

	public function note_to_approve($id){

		$this->init(new Note());
		$d["record"] = $this->model->get_by_id($id);

		$this->set($d);
		$this->render('note_to_approve');

	}

	public function create_assignment(){
		$this->init(new Note());
		$this->render('create_assignment');
	}

	public function create_suggested_point(){
		$this->init(new Note());
		$this->render('create_suggested_point');
	}

	public function create_agenda_point(){
		$this->init(new Note());
		$this->render('create_agenda_point');
	}

	public function create_commitment(){
		$this->init(new Note());
		$this->render('create_commitment');
	}
}
?>