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
	
	/**
	 * Description
	 * @return type
	 */
	public function create_assignment(){
		$this->init(new Note());
		if(isset($_POST) && isset($_POST['title'])){

			$users_name = $_POST['users_id'];
			$users = explode(';',$users_name);

			
			$users_id = array();

			foreach($users as $user_name){
				$row = Model::get_sql_data("select id from user where concat(names,' ',lastnames) = ?",
						array('user_name'=>$user_name));
				if(isset($row[0]['id'])){
					$users_id[] = $row[0]['id'];
				}
			}
			

			$data = $_POST;
			$data['user_id']=Session::get('user_id');

			/*TODO cambiar por un GlobalModuleConstants.Value*/
			$note_type = (new Note_Type())->get_by_property(array('name'=>'Asignaciones'));
			
			if($note_type)
				$data['note_type_id']=$note_type['id'];
			else
				$data['note_type_id']=1;

			Model::save_record($this->model,$data);
//var_dump($data);

			$note = $this->model->get_by_property(array('title'=>$data['title'],'summary'=>$data['summary']));
			
//var_dump($note);
//die;
			$note_approver_model = new Note_Approver();

			foreach($users_id as $user_id){
				$approver_data=array('note_id'=>$note['id'],'user_id'=>$user_id);
				Model::save_record($note_approver_model,$approver_data);
			}

			if($note)
				header("location: ".CoreUtils::base_url().'note/note_information/'.$note['id']);
			else 
				header("location: ".CoreUtils::base_url().'note/index');
		}
		if(Session::get('group_id')){
			$this->vars['records']['group_id']=Session::get('group_id');
		}
		$this->render('create_assignment');
	}

	public function create_suggested_point(){
		$this->init(new Note());

		if(isset($_POST) && isset($_POST['title'])){

			$users_name = $_POST['users_id'];
			$users = explode(';',$users_name);

			
			$users_id = array();

			foreach($users as $user_name){
				$row = Model::get_sql_data("select id from user where concat(names,' ',lastnames) = ?",
						array('user_name'=>$user_name));
				if(isset($row[0]['id'])){
					$users_id[] = $row[0]['id'];
				}
			}
			

			$data = $_POST;
			$data['user_id']=Session::get('user_id');

			/*TODO cambiar por un GlobalModuleConstants.Value*/
			$note_type = (new Note_Type())->get_by_property(array('name'=>'Punto Sugerido'));
			
			if($note_type)
				$data['note_type_id']=$note_type['id'];
			else
				$data['note_type_id']=1;

			Model::save_record($this->model,$data);
			$note = $this->model->get_by_property(array('title'=>$data['title'],'summary'=>$data['summary']));
			$note_approver_model = new Note_Approver();

			foreach($users_id as $user_id){
				$approver_data=array('note_id'=>$note['id'],'user_id'=>$user_id);
				Model::save_record($note_approver_model,$approver_data);
			}

			if($note)
				header("location: ".CoreUtils::base_url().'note/note_information/'.$note['id']);
			else 
				header("location: ".CoreUtils::base_url().'note/index');
		}

		if(Session::get('group_id')){
			$this->vars['records']['group_id']=Session::get('group_id');
		}
		$this->render('create_suggested_point');
	}

	public function create_agenda_point(){
		$this->init(new Note());

		if(isset($_POST) && isset($_POST['title'])){

			$users_name = $_POST['users_id'];
			$users = explode(';',$users_name);

			
			$users_id = array();

			foreach($users as $user_name){
				$row = Model::get_sql_data("select id from user where concat(names,' ',lastnames) = ?",
						array('user_name'=>$user_name));
				if(isset($row[0]['id'])){
					$users_id[] = $row[0]['id'];
				}
			}
			

			$data = $_POST;
			$data['user_id']=Session::get('user_id');

			/*TODO cambiar por un GlobalModuleConstants.Value*/
			$note_type = (new Note_Type())->get_by_property(array('name'=>'Punto de Agenda'));
			
			if($note_type)
				$data['note_type_id']=$note_type['id'];
			else
				$data['note_type_id']=1;

			Model::save_record($this->model,$data);
			$note = $this->model->get_by_property(array('title'=>$data['title'],'summary'=>$data['summary']));
			$note_approver_model = new Note_Approver();

			foreach($users_id as $user_id){
				$approver_data=array('note_id'=>$note['id'],'user_id'=>$user_id);
				Model::save_record($note_approver_model,$approver_data);
			}

			if($note)
				header("location: ".CoreUtils::base_url().'note/note_information/'.$note['id']);
			else 
				header("location: ".CoreUtils::base_url().'note/index');
		}

		if(Session::get('group_id')){
			$this->vars['records']['group_id']=Session::get('group_id');
		}
		$this->render('create_agenda_point');
	}

	public function create_commitment(){
		$this->init(new Note());

		if(isset($_POST) && isset($_POST['title'])){

			$users_name = $_POST['users_id'];
			$users = explode(';',$users_name);

			
			$users_id = array();

			foreach($users as $user_name){
				$row = Model::get_sql_data("select id from user where concat(names,' ',lastnames) = ?",
						array('user_name'=>$user_name));
				if(isset($row[0]['id'])){
					$users_id[] = $row[0]['id'];
				}
			}
			

			$data = $_POST;
			$data['user_id']=Session::get('user_id');

			/*TODO cambiar por un GlobalModuleConstants.Value*/
			$note_type = (new Note_Type())->get_by_property(array('name'=>'Compromisos'));
			
			if($note_type)
				$data['note_type_id']=$note_type['id'];
			else
				$data['note_type_id']=1;

			Model::save_record($this->model,$data);
			$note = $this->model->get_by_property(array('title'=>$data['title'],'summary'=>$data['summary']));
			$note_approver_model = new Note_Approver();

			foreach($users_id as $user_id){
				$approver_data=array('note_id'=>$note['id'],'user_id'=>$user_id);
				Model::save_record($note_approver_model,$approver_data);
			}

			if($note)
				header("location: ".CoreUtils::base_url().'note/note_information/'.$note['id']);
			else 
				header("location: ".CoreUtils::base_url().'note/index');
		}

		if(Session::get('group_id')){
			$this->vars['records']['group_id']=Session::get('group_id');
			Session::delete('group_id');
		}
		$this->render('create_commitment');
	}
}
?>